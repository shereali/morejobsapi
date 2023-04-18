<?php

namespace Database\Seeders;

use App\Models\AdsPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdsPositionSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        AdsPosition::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Right Section', 'key' => 'RIGHT_SECTION'], //1
            ['title' => 'Bottom Section', 'key' => 'BOTTOM_SECTION'], //2

            ['title' => 'Below Govt Section', 'key' => 'BELOW_GOVT_SECTION'], //3
            ['title' => 'Hot Jobs Right Section', 'key' => 'HOT_JOBS_RIGHT_SECTION'], //4
            ['title' => 'End of Content Section', 'key' => 'END_OF_CONTENT_SECTION'], //5
            ['title' => 'Middle of Content Section', 'key' => 'MIDDLE_OF_CONTENT_SECTION'],//6
            ['title' => 'Bellow Job Summary Section', 'key' => 'BELLOW_JOB_SUMMARY_SECTION'],//7
        ];

        AdsPosition::insert($data);
    }
}
