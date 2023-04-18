<?php

namespace App\Http\Controllers\Employer;

use App\Filters\employer\CvBankListFilters;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\CategoryType;
use App\Models\PackageSubscription;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\CommonService;
use App\Services\HelperService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CVBankController extends Controller
{
    public function index()
    {
        $cvCountSubCategory = DB::table('users')
            ->select('user_job_category.category_id', DB::raw("COUNT(user_job_category.category_id) AS cv_count"))
            ->where([
                'user_type' => 2,
                'status' => 1,
                'resume_completed' => 1
            ])
            ->join('user_job_category', 'user_job_category.user_id', 'users.id')
            ->groupBy('user_job_category.category_id');

        $data = CategoryType::select('id', 'title_en', 'title_bn')
            ->with(['categories' => function ($q) use ($cvCountSubCategory) {
                $q->select('id', 'title_en', 'title_bn', 'cvCountSubCategory.cv_count', 'category_type_id');
                $q->leftJoinSub($cvCountSubCategory, 'cvCountSubCategory', function ($join) {
                    $join->on('categories.id', '=', 'cvCountSubCategory.category_id');
                });
            }])
            ->get();

        return $this->response($data, 'cv bank count summary');
    }

    public function cvBankList(CvBankListFilters $filters, $id)
    {
        if ($this->hasExpiredCvBankSubscription()) {
            return $this->errorResponse('No available active subscription', 'SUBSCRIPTION_EXPIRED');
        }

        $expSubQuery = DB::table('user_experience')
            ->select('user_experience.user_id', DB::raw("SUM(TIMESTAMPDIFF(year, `from`, IFNULL(`to`, NOW()))) as user_exp_year, SUM(TIMESTAMPDIFF(month, `from`, IFNULL(`to`, NOW()))) as user_exp_month"))
            ->groupBy('user_experience.user_id');

        $subQuery = UserProfile::select(
            'user_profile.user_id',
            'user_profile.expected_salary',
            DB::raw("TIMESTAMPDIFF (YEAR, user_profile.dob, CURDATE()) AS age"),
            'expSubQuery.user_exp_year',
            'expSubQuery.user_exp_month',
            'user_profile.gender_id',
            'user_profile.job_level_id',
        )
            ->leftJoinSub($expSubQuery, 'expSubQuery', function ($join) {
                $join->on('user_profile.user_id', '=', 'expSubQuery.user_id');
            });

        $records = User::select('users.*',
            'subQuery.age',
            'subQuery.expected_salary',
            'subQuery.user_exp_year',
            'subQuery.user_exp_month',)
            ->whereHas('preferredJobCategories', function ($q) use ($id) {
                $q->where('category_id', $id);
            })
            ->joinSub($subQuery, 'subQuery', function ($join) {
                $join->on('users.id', '=', 'subQuery.user_id');
            })
            ->with('jobExperiences', function ($q) {
                $q->select('id', 'user_id', 'company_name', 'industry_type_id', 'designation', 'from', 'to', 'is_current',
                    DB::raw("TIMESTAMPDIFF(month, `from`, IFNULL(`to`, NOW())) as months"),
                );
            })
            ->with(['contactEmails', 'contactMobiles', 'specializations', 'educations'])
            // ->join('user_profile', 'users.id', 'user_profile.user_id')
            ->where([
                'user_type' => 2,
                'status' => 1,
                'resume_completed' => 1
            ])
            ->filter($filters)
            ->paginate(HelperService::getMAxItemLimit());

        $data['records'] = $records;
        $data['filter_initial_data'] = [
            'genders' => CommonService::genders(),
            'job_levels' => CommonService::jobLevels(),
            'job_natures' => CommonService::jobNatures(),
            'degree_levels' => CommonService::educationLevels(),
            'degrees' => CommonService::degrees(),
            'result_types' => CommonService::resultTypes(),
            'institutes' => CommonService::institutes(),
            'areas' => Area::where(function ($q) {
                $q->whereCountryId(1)->whereLevel(1);
            })->orWhere('country_id', '!=', 1)
                ->get(),
            'industry_types' => CommonService::industryTypes(),
        ];

        return $this->response($data, 'cv bank list');
    }

    public function decrementCvSubscription()
    {
        try {
            $data = $this->latestCvBankSubscription();
            if (empty($data)) {
                return $this->errorResponse('No available active subscription', 'SUBSCRIPTION_EXPIRED');
            }

            $data->remaining = $data->remaining - 1;
            $data->save();

            return $this->successResponse('Action success');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function latestCvBankSubscription()
    {
        return PackageSubscription::select('package_subscription.id', 'remaining')
            ->where([
                'company_id' => COMPANY_ID,
                'package_subscription.status' => 1
            ])
            ->where('remaining', '>', 0)
            ->where('expire_at', '>=', Carbon::now()->toDateTimeString())
            ->join('packages', 'packages.id', 'package_subscription.package_id')
            ->join('package_groups', 'package_groups.id', 'packages.package_group_id')
            ->join('package_types', function ($join) {
                $join->on('package_types.id', 'package_groups.package_type_id')->where('package_types.id', 2);
            })
            ->orderBy('expire_at', 'DESC')
            ->orderBy('remaining', 'ASC')
            ->first();
    }

    public function hasExpiredCvBankSubscription(): bool
    {
        $data = $this->latestCvBankSubscription();

        return empty($data);
    }
}
