<?php

namespace App\Http\Controllers\Employee\MyActivity;

use App\Filters\Employees\OnlineApplicationFilters;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\AuthService;
use App\Services\HelperService;

class ApplicationController extends Controller
{
    public function index(OnlineApplicationFilters $filters)
    {
        $data = Post::select('posts.id', 'posts.title', 'posts.company_id',
            'post_applicants.created_at as applied_at', 'post_applicants.is_viewed', 'post_applicants.status as application_status','post_applicants.expected_salary as expected_salary')
            ->with('company')
            ->join('post_applicants', 'posts.id', 'post_applicants.post_id')
            ->where('post_applicants.user_id', AuthService::getAuthUserId())
            ->filter($filters)
            ->orderBy('post_applicants.created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'My online applications');
    }

}
