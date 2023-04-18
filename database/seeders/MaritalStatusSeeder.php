<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MaritalStatusSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        MaritalStatus::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Married', 'view_order' => 1],
            ['title' => 'Unmarried', 'view_order' => 2],
            ['title' => 'Single', 'view_order' => 3],
        ];

        MaritalStatus::insert($data);
    }
}
