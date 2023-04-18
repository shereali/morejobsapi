<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PostApplicant;
use App\Models\User;
use App\Models\UserFavCompany;
use App\Models\UserFavPost;
use App\Services\AuthService;
use App\Services\StaticValueService;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function summary()
    {
        $data = PostApplicant::select(DB::raw("COUNT(*) AS total_online_application"),
            DB::raw("COUNT(CASE WHEN is_viewed = 1 THEN 1 END) AS total_resume_viewed"),
        //  DB::raw("COUNT(CASE WHEN status = 1 THEN 1 END) AS total_shortlisted")
        )
            ->whereUserId(AuthService::getAuthUserId())
            ->first();

        $resume = User::with('contactEmails', 'contactMobiles')
            ->with(['profile' => function ($q) {
                $q->with('gender', 'religion', 'maritalStatus', 'country', 'presentArea', 'permanentArea', 'jobLevel', 'jobNature');
            }])
            ->with(['educations' => function ($q) {
                $q->with('educationLevel', 'degree', 'resultType');
                $q->orderBy('view_order', 'ASC');
            }])
            ->with('trainings.country')
            ->with('specializations')
            ->with('preferredOrganizationTypes', 'preferredAreas', 'preferredJobCategories')
            ->with('languageProficiencies', 'jobExperiences', 'certifications', 'references')
            ->whereUserType(StaticValueService::userTypeIdByKey('employee'))
            ->findOrFail(AuthService::getAuthUserId());


        return $this->response([
            'total_online_application' => $data->total_online_application,
            'total_resume_viewed' => $data->total_resume_viewed,
            // 'total_shortlisted' => $data->total_shortlisted,
            'fav_post' => UserFavPost::whereUserId(AuthService::getAuthUserId())->count(),
            'fav_company' => UserFavCompany::whereUserId(AuthService::getAuthUserId())->count(),
            'resume_last_updated_at' => AuthService::getAuthUser()->updated_at,
            'resume' => $resume
        ], 'Employee summary');
    }
}
