<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ReligionSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Religion::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Buddhism', 'view_order' => 1],
            ['title' => 'Christianity', 'view_order' => 2],
            ['title' => 'Hinduism', 'view_order' => 3],
            ['title' => 'Islam', 'view_order' => 4],
            ['title' => 'Jainism', 'view_order' => 5],
            ['title' => 'Judaism', 'view_order' => 6],
            ['title' => 'Sikhism', 'view_order' => 7],
            ['title' => 'Others', 'view_order' => 8],
        ];

        Religion::insert($data);
    }
}
