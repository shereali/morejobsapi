<?php

namespace App\Http\Controllers\Employee\MyActivity;

use App\Filters\Employees\FollowingCompanyFilters;
use App\Filters\Employees\UnfollowedCompanyFilters;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Post;
use App\Models\UserFavCompany;
use App\Services\AuthService;
use App\Services\CommonService;
use App\Services\HelperService;

class FollowCompanyController extends Controller
{
    public function index(FollowingCompanyFilters $filters)
    {
        $data = UserFavCompany::with(['company' => function ($q) {
            $q->withCount('jobs');
        }])
            ->whereUserId(AuthService::getAuthUserId())
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Employee favorite companies');
    }

    public function unfollowCompany($companyId)
    {
        try {
            AuthService::getAuthUser()->favCompanies()->detach($companyId);

            return $this->successResponse('Company unfollowed successfully');
        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function initiateFilterUnfollowedCompanyList()
    {
        $industryTypes = CommonService::industryTypes();

        return $this->response([
            'industry_types' => $industryTypes,
        ], 'Initiate filters for unfollowed company list');

    }

    public function companyList(UnfollowedCompanyFilters $filters)
    {
        $data = Company::withCount('jobs')
            ->having('jobs_count', '>', 0)
//            ->whereNotIn('id', function ($q) {
//                $q->select('company_id')
//                    ->from(with(new UserFavCompany)->getTable())
//                    ->where('user_id', AuthService::getAuthUserId());
//            })
            ->filter($filters)
            ->orderBy('title_en', 'ASC')
            ->paginate(HelperService::getMAxItemLimit(50));

        return $this->response($data, ' Followable companies');
    }

    public function companyShow($companyId)
    {
        $data = Post::whereCompanyId($companyId)->get();

        $isFollowed = UserFavCompany::whereUserId(AuthService::getAuthUserId())->whereCompanyId($companyId)->first();

        return $this->response([
            'available_jobs' => $data,
            'is_followed' => !empty($isFollowed)
        ], 'Unfollowed company details');
    }

    public function followCompany($companyId)
    {
        try {
            AuthService::getAuthUser()->favCompanies()->attach($companyId);

            return $this->successResponse('Company followed successfully');
        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
