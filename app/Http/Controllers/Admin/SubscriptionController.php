<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\SubscriptionFilters;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PackageSubscription;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function initiateListSummary()
    {
        $summary = PackageSubscription::select(DB::raw("COUNT(*) AS total, COUNT(CASE WHEN status = 0 THEN 1 END) AS pending,
            COUNT(CASE WHEN status = 1 THEN 1 END) AS approved"),
//            DB::raw("COUNT(CASE WHEN status = 2 THEN 1 END) AS inactive")
        )
            ->first();

        return $this->response([
            'summary' => $summary,
            'initial_data' => [
                'companies' => Company::select('id', 'title_en')
                    ->whereIn('id', function ($q) {
                        $q->from('package_subscription')->selectRaw('distinct company_id');
                    })
                    ->orderBy('title_en', 'ASC')
                    ->get(),
            ]
        ], 'subscription list summary');
    }

    public function index(SubscriptionFilters $filters): JsonResponse
    {
        $data = PackageSubscription::with('company', 'package', 'detail')
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(20));

        return $this->response($data, 'Package subscription list');
    }

    public function show($id): JsonResponse
    {
        $data = PackageSubscription::with('company', 'package', 'detail')->findOrFail($id);

        return $this->response($data, 'Subscription details');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1,2'
        ]);

        $data = PackageSubscription::findOrFail($id);

        try {
            $data->fill($request->only('status'));
            $data->save();

            return $this->successResponse('Subscription status changed successfully', $data);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
