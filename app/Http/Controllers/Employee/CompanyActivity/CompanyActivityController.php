<?php

namespace App\Http\Controllers\Employee\CompanyActivity;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\AuthService;
use App\Services\HelperService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class CompanyActivityController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Post::select('posts.company_id', 'post_applicants.updated_at as viewed_at', 'post_applicants.is_viewed')
            ->with('company')
            ->join('post_applicants', 'posts.id', 'post_applicants.post_id')
            ->where('post_applicants.user_id', AuthService::getAuthUserId())
            ->orderBy('post_applicants.created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Company resume view list');
    }

    public function cvSummary()
    {
        $user = User::with('contactMobiles', 'jobExperiences', 'profile', 'educations')->findOrFail(AuthService::getAuthUserId());

        $jobExperiences = $user->jobExperiences->map(function ($item) {
            $item['exp_duration'] = Carbon::parse($item['from'])->diff(Carbon::parse($item['to']))->format('%y years %m months');
            $item['exp_duration_in_days'] = Carbon::parse($item['from'])->diffInDays(Carbon::parse($item['to']));
            return $item;
        });

        $jobExpInTotalDays = $jobExperiences->sum('exp_duration_in_days');
        $years = floor($jobExpInTotalDays / 365);
        $months = floor(($jobExpInTotalDays - ($years * 365)) / 30.5);

        return $this->response([
            'user' => $user->only('id', 'first_name', 'last_name', 'image'),
            'mobile' => $user->contactMobiles->first(),
            'education' => $user->educations->first(),
            'job_experiences' => $jobExperiences,
            'other' => [
                'total_age' => $user->profile ? Carbon::parse($user->profile->dob)->diff(Carbon::now())->format('%y.%m') : 'n/a',
                'total_exp' => [
                    'years' => $years,
                    'months' => $months
                ]
            ]
        ], 'cv summary');

    }
}
