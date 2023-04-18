<?php

namespace Database\Seeders;

use App\Models\TrainingType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TrainingTypeSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        TrainingType::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Daylong Courses'],
            ['title' => 'Evening Courses'],
            ['title' => 'Customised Courses'],
            ['title' => 'Online Courses'],
        ];

        TrainingType::insert($data);
    }
}
