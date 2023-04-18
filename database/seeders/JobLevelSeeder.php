<?php

namespace Database\Seeders;

use App\Models\JobLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class JobLevelSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        JobLevel::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Entry level', 'view_order' => 1],
            ['title' => 'Mid level', 'view_order' => 2],
            ['title' => 'Top level', 'view_order' => 3],
        ];

        JobLevel::insert($data);
    }
}
