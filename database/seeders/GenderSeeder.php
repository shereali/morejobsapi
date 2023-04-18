<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GenderSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Gender::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Male', 'view_order' => '1'],
            ['title' => 'Female', 'view_order' => '2'],
            ['title' => 'Others', 'view_order' => '3'],
        ];

        Gender::insert($data);
    }
}
