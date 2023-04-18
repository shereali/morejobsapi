<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Services\CommonService;
use App\Services\FileHandleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function editCompanyInitiate()
    {
        $company = Company::with('area.parent', 'contactPersons', 'industryTypes')->findOrFail(COMPANY_ID);
        $company['country_id'] = @$company->area->country_id;

        $company['district_id'] = null;
        $company['thana_id'] = null;
        if (@$company->area->parent) {
            $company['district_id'] = $company->area->parent->id;
            $company['thana_id'] = $company->area->id;
        } elseif (@$company->area) {
            $company['district_id'] = $company->area->id;
        }

        $company['primary_contact'] = $company->contactPersons->where('is_primary', 1)->first();


        $data['company'] = $company;
        $data['initial_data'] = [
            'countries' => Country::with('districts.thanas')->get(),
            'industry_types' => CommonService::industryTypeWithChild(),
            'organization_types' => CommonService::organizationTypes(),
        ];

        return $this->response($data, 'edit company');
    }

    public function editCompany(Request $request)
    {
        $this->validate($request, [
            'country_id' => 'required',
            'district_id' => 'required_if:country_id,1',
            'thana_id' => 'required_if:country_id,1',
            'address_en' => 'required',
            'selected_industry_types' => 'required|array|min:1',
            'organization_type_id' => 'required',
            'primary_contact' => 'required|integer',
        ]);

        $company = Company::findOrFail(COMPANY_ID);

        if ($request->country_id == 1) {
            $areaId = $request->thana_id;
        } else {
            $areaId = $request->country_id;
        }

        try {
            DB::beginTransaction();

            $company->fill($request->only('title_bn', 'address_en', 'address_bn', 'about', 'trade_licence_no', 'rl_no', 'website', 'organization_type_id'));
            $company['area_id'] = $areaId;
            $company->save();

            $company->industryTypes()->detach();
            foreach ($request->selected_industry_types as $item) {
                $company->industryTypes()->attach($item['id']);
            }

            $company->contactPersons()->update([
                'is_primary' => 0
            ]);

            $company->contactPersons()->where('id', $request->primary_contact)->update([
                'is_primary' => 1
            ]);

            DB::commit();
            return $this->successResponse('Company & related data updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function uploadLogo(Request $request)
    {
        $this->validate($request, [
            'file' => 'mimes:jpeg,jpg,png,gif|max:2024'
        ]);

        $company = Company::findOrFail(COMPANY_ID);

        try {
            DB::beginTransaction();

            FileHandleService::delete($company->logo);

            if ($request->hasFile('file')) {
                $company->logo = FileHandleService::upload($request->file, FileHandleService::getCompanyPath($company->id));

                $company->save();
                $message = 'Logo changed successfully';
            } else {
                $company->logo = null;
                $company->save();
                $message = 'Logo deleted successfully';
            }

            DB::commit();
            return $this->successResponse($message, $company);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }
}
