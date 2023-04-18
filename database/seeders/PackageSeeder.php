<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageDetail;
use App\Models\PackageGroup;
use App\Models\PackageType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        PackageType::truncate();
        Package::truncate();
        PackageGroup::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Job', 'view_order' => 1, 'status' => 1],
            ['title' => 'CV Bank', 'view_order' => 2, 'status' => 0],
            ['title' => 'Bulk Subscription', 'view_order' => 3, 'status' => 0],
            ['title' => 'Others', 'view_order' => 4, 'status' => 0],
        ];

        PackageType::insert($data);

        $data = [
            ['title' => 'Basic Listing', 'package_type_id' => 1, 'is_recommended' => 0, 'view_order' => 1],
            ['title' => 'Stand Out Listing', 'package_type_id' => 1, 'is_recommended' => 1, 'view_order' => 2],
            ['title' => 'Hot Job Listing', 'package_type_id' => 1, 'is_recommended' => 0, 'view_order' => 3],
        ];

        PackageGroup::insert($data);

        $data = [
            ['title' => 'Basic Listing', 'package_group_id' => 1, 'features' => ' Jobs displayed in the Category/Classified section.
 Job will be live for 30 days (max).
 Sort matching CVs, short-list, interview scheduling through convenient employer\'s panel.
10 times cheaper than a newspaper advertisement.
10 times Each job post costs 2,950 BDT only.'],
            ['title' => 'Stand Out Listing', 'package_group_id' => 2, 'features' => 'Make your job circular Stand-out among thousands of job circular.
Jobs displayed in the Category/Classified section with Logo and different background-color.
Jobs will be displayed for 30 days (max).
20% more view than Basic Listing jobs.
Each job post costs 3,900 BDT only.'],
            ['title' => 'Stand Out Premium', 'package_group_id' => 2, 'features' => 'Your job circular will be displayed on the top of the 1st page of its particular category for 3 days and the next 3 days on the 2nd page.
All the other features will be as Stand-out listing.
Each job post costs 4,900 BDT only.'],
            ['title' => 'Hot job', 'package_group_id' => 3, 'features' => 'Display your company logo and position name on the homepage of morejobsbd.net.
Customized web page for your job circular.
10 days display in the Hot Jobs section, then in the classified section up to 30 days as Stand-out jobs.
Service charge for each job post is Tk. 11,000 BDT. The rate gradually decreases as the number of posts increases.'],
            ['title' => 'Hot job Premium', 'package_group_id' => 3, 'features' => 'Get priority in the Hot Jobs list.
Your jobs will be displayed within the top 5 rows up to 5 days.
15 days display in the Hot Jobs section.
Service charge for each job post is Tk. 13,500 BDT. The rate gradually decreases as the number of posts increases.'],
        ];

        Package::insert($data);

        $data = [
            ['package_id' => '1', 'quantity_from' => 1, 'quantity_to' => 1, 'price' => 2950],
            ['package_id' => '2', 'quantity_from' => 1, 'quantity_to' => 1, 'price' => 3900],
            ['package_id' => '3', 'quantity_from' => 1, 'quantity_to' => 1, 'price' => 4900],
            ['package_id' => '4', 'quantity_from' => 1, 'quantity_to' => 1, 'price' => 11000],
            ['package_id' => '5', 'quantity_from' => 1, 'quantity_to' => 1, 'price' => 13500],
        ];

        PackageDetail::insert($data);
    }

}
