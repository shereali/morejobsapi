<?php

namespace Database\Seeders;

use App\Models\AdsPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdsPageSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        AdsPage::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Landing', 'key' => 'LANDING', 'positions' => [3, 4, 2]],
            ['title' => 'Job List', 'key' => 'JOB_LIST', 'positions' => [1, 5, 6, 2]],
            ['title' => 'Job Details', 'key' => 'JOB_DETAILS', 'positions' => [1, 2, 5, 7]],
        ];

        foreach ($data as $ad) {
            foreach ($ad['positions'] as $position) {
                AdsPage::insert([
                    'title' => $ad['title'],
                    'key' => $ad['key'],
                    'ad_position_id' => $position,
                ]);
            }

        }
    }
}
