<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DummyDataSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Company::truncate();
        DB::table('company_user')->truncate();
        DB::table('company_industry')->truncate();
        DB::table('company_contact_persons')->truncate();
        DB::table('posts')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create();

        $user = new User();
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->username = 'admin@morejobs.com';
        $user->password = Hash::make('admin1234');
        $user->status = 1;
        $user->account_verified_at = Carbon::now();
        $user->user_type = 1;
        $user->save();


        for ($i = 1; $i < 6; $i++) {
            $user = new User();
            $user->first_name = 'Employer' . $i;
            $user->last_name = 'last name' . $i;
            $user->username = "employer$i@morejobs.com";
            $user->password = Hash::make('123456');
            $user->status = 1;
            $user->account_verified_at = Carbon::now();
            $user->user_type = 3;
            $user->save();


            $company = new Company();
            $company->title_en = 'Demo company' . $i;
            $company->title_bn = 'Demo company bn';
            $company->address_en = 'Dhaka kalshi mirpur 12';
            $company->about = 'About of demo company';
            $company->status = 1;
            $company->website = 'https://www.demo.morejobs.com';
            $company->save();

            DB::table('company_user')->insert([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'user_type' => 1,
                'status' => 1,
            ]);

            $company->industryTypes()->attach($i);

            $company->contactPersons()->create([
                'name' => 'Hasan',
                'designation' => 'CEO',
                'mobile_no' => '01923585801',
                'email' => 'hasan@gmail.com',
            ]);


            for ($i1 = 0; $i1 < 5; $i1++) {
                $post = Post::create(
                    [
                        'category_id' => rand(1, 5),
                        'company_id' => $company->id,
                        'title' => $faker->name,
                        'service_type_id' => rand(1, 3),
                        'no_of_vacancy' => rand(1, 10),
                        'job_context' => 'Full stack Developer MS SQL, Node.js, AngularJS',
                        'responsibilities' => 'Design database and scale it efficiently
Maintain best practices, responsiveness, pixel perfection, and quality code
Write technical documentation
Communicate and provide technical support to local and international clients
Maintain a version controlling system and project management tool
Advanced Web Application development using MEAN stack
Able to transform Wireframes or PSD Designs into functional Web Applications using MERN or MEAN stack (React, Node.js, MSSQL, AngularJS, Express, Loopback Api
Advanced knowledge in BOTH Frontend and Backend web development using JS
Develop cross-platform compatible web application',
                        'salary_min' => rand(5000, 10000),
                        'salary_max' => rand(20000, 90000),
                        'deadline' => '2021-08-01',
                        'is_profile_image' => 1,
                        'salary_type' => 3,
                        'is_display_salary' => 1,
                        'additional_salary_info' => '',
                        'additional_requirements' => 'Age 30 to 40 years
Skills Required: MS SQL Backend Development, AngularJS, Full Stack Development, NodeJS, Web Application Development
Experience Requirements
At least 5 year(s)
The applicants should have experience in the following area(s):
MSSQL Backend Development & Admin, Full Stack Development, Node JS, web application development',
                        'other_qualification' => '5 to 7 year(s)
The applicants should have experience in the following area(s):
Programmer Software Engineer, Basic Web Development, Computer Software
The applicants should have experience in the following business area(s):
Garments, Garments Accessories, Group of Companies',
                        'is_experience_require' => 1,
                        'is_fresher_allowed' => 1,
                        'experience_min' => 1,
                        'experience_max' => 3,
                        'age_min' => 18,
                        'age_max' => 25,
                        'company_name' => $company->title_en,
                        'total_view' => 10,
                        'status' => rand(0, 3)
                    ]);

                $post->postNatures()->sync([rand(1, 3)]);
                $post->postLevels()->sync([rand(1, 3)]);
                $post->postWorkspaces()->sync([rand(1, 2)]);
                $post->postGenders()->sync(collect([rand(1, 3)]));
            }
        }


        for ($i = 1; $i < 30; $i++) {
            $user = new User();
            $user->first_name = 'Employee' . $i;
            $user->last_name = 'last name' . $i;
            $user->username = "employee$i@morejobs.com";
            $user->password = Hash::make('123456');
            $user->status = 1;
            $user->account_verified_at = Carbon::now();
            $user->user_type = 2;
            $user->save();

            $user->profile()->create([
                'father_name' => $faker->name,
                'mother_name' => $faker->name,
                'dob' => Carbon::now()->toDateTimeString(),
                'gender_id' => rand(1, 3),
                'religion_id' => rand(1, 3),
                'marital_status_id' => rand(1, 3),
                'country_id' => 1,
                'job_level_id' => rand(1, 2),
                'job_nature_id' => rand(1, 2),
                'present_salary' => rand(1000, 2000),
                'expected_salary' => rand(10000, 20000),
            ]);

            $user->contactEmails()->delete();
            $user->contacts()->create([
                'title' => $user->username,
                'type' => 1
            ]);


            $user->educations()->createMany([
                [
                    'education_level_id' => 1,
                    'degree_id' => 1,
                    'hide_mark' => 1,
                    'passing_year' => 2000 + $i,
                    'duration' => 4,
                    'institute_name' => 'Khulan university',
                    'cgpa' => 3.20,
                ],
                [
                    'education_level_id' => 2,
                    'degree_id' => 2,
                    'hide_mark' => 1,
                    'passing_year' => 2000 + $i + 1,
                    'duration' => 4,
                    'institute_name' => 'Khulan university',
                    'cgpa' => 3.20 + 0.3,
                ]
            ]);


            $posts = Post::all();
            $users = User::where('user_type', 2)->get();

            foreach ($posts as $post) {
                foreach ($users as $user) {
                    $post->applicants()->create([
                        'user_id' => $user->id,
                        'status' => rand(0, 3),
                        'is_viewed' => rand(0, 1),
                    ]);


                    DB::table('user_fav_post')->insert([
                        'post_id' => $post->id,
                        'user_id' => $user->id,
                    ]);
                }

            }
        }
    }
}
