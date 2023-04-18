<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\PackageGroup;
use App\Models\PackageSubscription;
use App\Models\PackageType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function packageTypes()
    {
        $packageTypes = PackageType::select('id', 'title', 'frontend_url')->where('status', 1)->orderBy('view_order')->get();

        return $this->successResponse('package types', $packageTypes);
    }

    public function initiate(Request $request): JsonResponse
    {
        $pageTypeId = $request->has('package_type_id') ? $request->package_type_id : 1;

        $packageGroups = PackageGroup::with('packages', 'packages.details')->where('package_type_id', $pageTypeId)->get();

        /*$packages = Package::with('details', 'group')->whereHas('group', function ($query) use ($pageTypeId) {
            $query->where('package_type_id', $pageTypeId);
        })->get();*/

        $packageType = PackageType::select('id', 'description')->findOrFail($pageTypeId);

        $data['package_groups'] = $packageGroups;
        $data['package_type'] = $packageType;

        return $this->successResponse('package list', $data);
    }

    public function subscribed(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            foreach ($data as $key => $value) {
                $unitPrice = $value['unit_price'] * $value['quantity'];
                $data = new PackageSubscription();
                $data->package_id = $value['package_id'];
                $data->package_detail_id = $value['package_detail_id'];
                $data->company_id = COMPANY_ID;
                $data->quantity = $value['quantity'];
                $data->remaining = $value['quantity'];
                $data->paid = 0;
                $data->total = $unitPrice + ($unitPrice * 0.05);
                $data->subscribe_at = Carbon::now(); //TODO:: should update after admin approval
                $data->expire_at = Carbon::now()->addMonths(12)->format('Y-m-d'); //TODO:: should dynamic
                $data->save();
            }
            return $this->successResponse('Subscribed successfully!');
        } catch (\Exception $e) {
            return $this->exception($e);
        }

    }

    public function subscribedPackages($type = 'web')
    {
        $data = PackageSubscription::with('package', 'detail')->where('company_id', COMPANY_ID)
            ->orderBy('id', 'DESC')->get();
        if ($type == 'web') {
            return $this->successResponse('package list', $data);
        } else {
            return $data;
        }


    }

    public function cancel(Request $request): JsonResponse
    {
        try {
            //TODO:: Should check uses limit expire date, payment later
            if ($request->has('id')) {
                $data = PackageSubscription::findOrFail($request->id);
                $data->status = 2;
                $data->remaining = 0;
                $data->save();
                $result = $this->subscribedPackages('internal');
                return $this->successResponse('package list', $result);
            }
            return $this->errorResponse('Something went wrong');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!');
        }

    }
}
