<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        //Super admin user create
        $user = new User();
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->username = 'admin@morejobs.com';
        $user->password = Hash::make('admin1234');
        $user->status = 1;
        $user->account_verified_at = Carbon::now();
        $user->user_type = 1;
        $user->save();

//        $user = new User();
//        $user->first_name = 'Employee1';
//        $user->last_name = 'Employee last name';
//        $user->username = 'employee1@morejobs.com';
//        $user->password = Hash::make('123456');
//        $user->status = 1;
//        $user->account_verified_at = Carbon::now();
//        $user->user_type = 2;
//        $user->save();
//
//        $user = new User();
//        $user->first_name = 'Employer1';
//        $user->last_name = 'Employer1 last name';
//        $user->username = 'employer1@morejobs.com';
//        $user->password = Hash::make('123456');
//        $user->status = 1;
//        $user->account_verified_at = Carbon::now();
//        $user->user_type = 3;
//        $user->save();
//
//        $company = new Company();
//        $company->title_en = 'Demo company 1';
//        $company->title_bn = 'Demo company bn 1';
//        $company->address_en = 'Dhaka kalshi mirpur 12';
//        $company->about = 'About of demo company';
//        $company->status = 1;
//        $company->website = 'https://www.demo.morejobs.com';
//        $company->save();
//
//        $user->companies()->attach($company->id, [
//            'user_type' => 1,
//            'status' => 1
//        ]);
//
//        $company->industryTypes()->attach(1);
//
//        $company->contactPersons()->create([
//            'name' => 'Hasan',
//            'designation' => 'CEO',
//            'mobile_no' => '01923585801',
//            'email' => 'hasan@gmail.com',
//        ]);


        //oauth
        DB::table('oauth_clients')->truncate();
        DB::table('oauth_clients')->insert(
            [
                'id' => env('CLIENT_ID', 1),
                'name' => 'job portal',
                'secret' => env('CLIENT_SECRET', 'SV6lm6wp3hYN8ewOIi6fqIhvxoO5RYr68UaS4ZsB'),
                'password_client' => 1,
                'redirect' => '',
                'personal_access_client' => 0,
                'revoked' => 0,
            ]);
    }
}
