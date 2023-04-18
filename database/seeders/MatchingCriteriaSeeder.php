<?php

namespace Database\Seeders;

use App\Models\MatchingCriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MatchingCriteriaSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        MatchingCriteria::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Age'],
            ['title' => 'Job Location'],
            ['title' => 'Total year of experience'],
            ['title' => 'Salary'],
            ['title' => 'Gender'],
            ['title' => 'Area of business'],
            ['title' => 'Area of experience'],
            ['title' => 'Job level'],
            ['title' => 'Skills'],
        ];

        MatchingCriteria::insert($data);
    }
}
