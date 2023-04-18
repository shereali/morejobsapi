<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\CompanyFilters;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\CommonService;
use App\Services\FileHandleService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function initiateListSummary()
    {
        $summary = Company::select(DB::raw("COUNT(CASE WHEN status = 0 THEN 1 END) AS pending"),
            DB::raw("COUNT(CASE WHEN status = 1 THEN 1 END) AS approved"),
            DB::raw("COUNT(CASE WHEN status = 2 THEN 1 END) AS inactive"))
            ->first();

        return $this->response([
            'summary' => $summary,
            'initial_data' => [
                'organization_types' => CommonService::organizationTypes()
            ]
        ], 'company list summary');
    }

    public function index(CompanyFilters $filters): JsonResponse
    {
        $data = Company::with('organizationType', 'area', 'industryTypes')
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(20));

        return $this->response($data, 'Company list');
    }

    public function show($id): JsonResponse
    {
        $data = Company::with('defaultContact', 'contacts', 'area', 'users')->findOrFail($id);

        return $this->response($data, 'Company details');
    }

    public function store(Request $request)
    {
        if ($request->selected_industry_types) {
            $request->request->add([
                'selected_industry_types' => json_decode($request->selected_industry_types)
            ]);
        }

        $this->validate($request, [
            'title_en' => 'required|string',
            'country_id' => 'required',
            'district_id' => 'required_if:country_id,1',
            'thana_id' => 'required_if:country_id,1',
            'address_en' => 'required',
            'selected_industry_types' => 'required|array|min:1',
            'organization_type_id' => 'required',
            'mode' => 'required|in:create,edit',
            'id' => 'required_if:mode,edit'
        ]);

        if ($request->country_id == 1) {
            $areaId = $request->thana_id;
        } else {
            $areaId = $request->country_id;
        }

        try {
            DB::beginTransaction();

            if ($request->mode == 'create') {
                $company = Company::create($request->only('title_en', 'title_bn', 'organization_type_id', 'address_en',
                        'address_bn', 'about', 'website', 'year_establishment', 'company_size') + [
                        'area_id' => $areaId,
                        'status' => 1,
                        'created_by' => 1, //1=admin created
                    ]);

                $path = FileHandleService::upload($request->file, FileHandleService::getCompanyPath($company->id));
                $company->logo = $path;
                $company->save();

                $message = "Company created successfully";

            } else {
                $company = Company::findOrFail($request->id);

                $path = null;
                if ($request->has('file') && $request->file) {
                    FileHandleService::delete($company->logo);
                    $path = FileHandleService::upload($request->file, FileHandleService::getCompanyPath($company->id));
                }

                $company->fill($request->only('title_en', 'title_bn', 'organization_type_id', 'address_en', 'address_bn',
                    'about', 'website', 'year_establishment', 'company_size'));
                $company['area_id'] = $areaId;
                if ($path) {
                    $company->logo = $path;
                }

                $company->save();

                $message = "Company updated successfully";
            }

            $company->industryTypes()->detach();
            foreach ($request->selected_industry_types as $item) {
                $company->industryTypes()->attach($item->id);
            }

            DB::commit();
            return $this->successResponse($message, $company);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1,2'
        ]);

        $company = Company::findOrFail($id);

        try {
            $company->fill($request->only('status'));
            $company->save();

            return $this->successResponse('Company status changed successfully', $company);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
