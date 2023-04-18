<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('service_types')->truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title_en' => 'Basic Listing', 'title_bn' => 'বেসিক তালিকা'],
            ['title_en' => 'Stand-out Listing', 'title_bn' => 'সস্ট্যান্ড-আউট তালিকা'],
            ['title_en' => 'Stand Out Premium', 'title_bn' => 'প্রিমিয়াম স্ট্যান্ড আউট'],
        ];

        DB::table('service_types')->insert($data);
    }
}
