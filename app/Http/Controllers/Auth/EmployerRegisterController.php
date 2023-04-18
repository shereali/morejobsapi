<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyContactPerson;
use App\Models\Country;
use App\Models\User;
use App\Services\AccountService;
use App\Services\AuthService;
use App\Services\CommonService;
use App\Services\StaticValueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployerRegisterController extends Controller
{
    public function initiateEmployerRegister()
    {
        return $this->response([
            'countries' => Country::with(['districts' => function ($q) {
                $q->with(['thanas' => function ($q) {
                    $q->orderBy('title_en', 'ASC');
                }]);
                $q->orderBy('title_en', 'ASC');
            }])->get(),
            'industry_types' => CommonService::industryTypeWithChild(),
            'organization_types' => CommonService::organizationTypes()->values(),
        ], 'Initiate employer register');
    }

    public function employerRegister(Request $request)
    {
        
        
        $customAttributes = [
            'username' => 'email/mobile',
        ];

        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'title_en' => 'required',
            'country_id' => 'required',
            'district_id' => 'required_if:country_id,1',
            'thana_id' => 'required_if:country_id,1',
            'address_en' => 'required',
            'selected_industry_types' => 'required|array|min:1',
            'organization_type_id' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'email' => 'required|email',
        ], [], $customAttributes);

        if ($request->mobile_no) {
            AccountService::validatePhoneNo($request->mobile_no, 'mobile_no');
        }

        if ($request->country_id == 1) {
            $areaId = $request->thana_id;
        } else {
            $areaId = $request->country_id;
        }

        $regMedium = AccountService::isEmailOrMobile($request->username);

        if ($regMedium == StaticValueService::regMediumId('mobile')) {
            AccountService::validatePhoneNo($request->username, 'username');
            $userName = AccountService::getFormattedPhoneNo($request->username);
        } else {
            $userName = $request->username;
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->title_en,
                'username' => $userName,
                'password' => Hash::make($request->password),
                'user_type' => StaticValueService::userTypeIdByKey('employer'),
                'reg_medium' => $regMedium,
                'status' => 1
            ]);

            $company = Company::create([
                'title_en' => $request->title_en,
                'title_bn' => $request->title_bn,
                'year_establishment' => $request->year_establishment,
                'company_size' => $request->company_size,
                'address_en' => $request->address_en,
                'address_bn' => $request->address_bn,
                'about' => $request->about,
                'area_id' => $areaId,
                'website' => $request->website,
                'trade_licence_no' => $request->trade_licence_no,
                'rl_no' => $request->rl_no,
                'organization_type_id' => $request->organization_type_id,
                'status' => 0,
            ]);

            $user->companies()->attach($company->id, [
                'user_type' => 1,
                'status' => 1,
            ]);

            CompanyContactPerson::create([
                'name' => $request->name,
                'designation' => $request->designation,
                'company_id' => $company->id,
                'mobile_no' => $company->mobile_no,
                'email' => $company->email,
            ]);

            foreach ($request->selected_industry_types as $item) {
                $company->industryTypes()->attach($item['id']);
            }


            $token = AuthService::generateAuthToken($request);

            if (empty($token)) {
                return $this->errorResponse('Something went wrong. Token not generated');
            }

            if (property_exists($token, 'error')) {
                return $this->errorResponse('Token generation failure.');
            }

            $token->user = $user;

            DB::commit();
            return $this->successResponse('Registration success. You may login now.', $token);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }
}
