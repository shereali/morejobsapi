<?php

namespace App\Http\Controllers\Admin;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use App\Services\HelperService;
use App\Services\StaticValueService;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function index(UserFilters $filters): JsonResponse
    {
        $data = User::filter($filters)
            ->where('user_type', StaticValueService::userTypeIdByKey('employee'))
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(50));

        return $this->response($data, 'Employee list');
    }

    public function show($id)
    {
        $data = User::with('contactEmails', 'contactMobiles')
            ->with(['profile' => function ($q) {
                $q->with('gender', 'religion', 'maritalStatus', 'country', 'presentArea', 'permanentArea', 'jobLevel', 'jobNature');
            }])
            ->with(['educations' => function ($q) {
                $q->with('educationLevel', 'degree', 'resultType');
                $q->orderBy('view_order', 'ASC');
            }])
            ->with('trainings.country')
            ->with('specializations')
            ->with(['jobExperiences' => function ($q) {
                $q->with('industryType');
                $q->orderBy('from', 'DESC');
            }])
            ->whereUserType(StaticValueService::userTypeIdByKey('employee'))
            ->findOrFail($id);

        return $this->response($data, 'Employee resume details');
    }
}
