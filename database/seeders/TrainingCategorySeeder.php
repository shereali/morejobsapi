<?php

namespace Database\Seeders;

use App\Models\TrainingCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TrainingCategorySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        TrainingCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Accounts & Finance'],
            ['title' => 'Administration'],
            ['title' => 'Banking & Financial'],
            ['title' => 'Business Management'],
            ['title' => 'Commercial'],
            ['title' => 'Development/ NGO'],
            ['title' => 'Freelancing'],
            ['title' => 'Health'],
            ['title' => 'HR'],
            ['title' => 'IT'],
            ['title' => 'Law'],
            ['title' => 'Marketing/ Sales'],
            ['title' => 'Next Stage/ Career'],
            ['title' => 'Other Specialized'],
            ['title' => 'Project Management'],
            ['title' => 'Quality & Process'],
            ['title' => 'RMG'],
            ['title' => 'Soft Skills'],
        ];

        TrainingCategory::insert($data);
    }
}
