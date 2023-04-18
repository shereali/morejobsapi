<?php

namespace App\Http\Controllers\Home;

use App\Filters\Home\CompanyFilters;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\UserFavCompany;
use App\Services\AuthService;
use App\Services\CommonService;
use App\Services\HelperService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function index(Request $request, CompanyFilters $filters)
    {
        $records = Company::withCount('jobs')
            ->having('jobs_count', '>', 0)
            ->filter($filters)
            ->orderBy('title_en', 'ASC')
            ->paginate(HelperService::getMAxItemLimit(20));

        $totalRecords = $records->total();

        if ($request->ajax()) {
            $html = view('pages.employerList.content', compact('records'))->render();

            return compact('html', 'totalRecords');
        }

        $data['organization_types'] = CommonService::organizationTypes();

        return view('pages.employerList.index', compact('records', 'data', 'totalRecords'));
    }

    public function show($id)
    {
        $data = Company::with('jobs')->findOrFail($id);

        return view('pages.employerList.show', compact('data'));
    }

    public function availableJobs($id)
    {
        $toDay = Carbon::now()->toDateTimeString();

        $data = Company::with(['jobs' => function ($q) use ($toDay) {
            $q->where('status', 2);
            $q->where('deadline', '>', $toDay);
        }])->findOrFail($id);

        return view('pages.employerList.available-jobs', compact('data'));
    }

    public function checkFollowed($id)
    {
        $isFollowed = false;
        if (Auth::id()) {
            $isFollowed = UserFavCompany::where('company_id', $id)->where('user_id', Auth::id())->exists();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_followed' => $isFollowed,
            ]
        ]);
    }

    public function followUnfollowCompany($id)
    {
        $data = AuthService::getAuthUser()->favCompanies()->where('companies.id', $id)->first();

        try {
            if ($data) {
                AuthService::getAuthUser()->favCompanies()->detach($id);
                $actionText = 'unfollowed';
            } else {
                AuthService::getAuthUser()->favCompanies()->attach($id);

                $actionText = 'followed';
            }

            return $this->successResponse("Company $actionText successfully", [
                'action_type' => $actionText
            ]);
        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function services()
    {
        return view('pages.employerServices');
    }
}
