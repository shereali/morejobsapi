<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\JobListingType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class InstituteSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Institute::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Dhaka University'],
            ['title' => 'Chittagong University'],
            ['title' => 'Khulna University'],
        ];

        Institute::insert($data);
    }
}
