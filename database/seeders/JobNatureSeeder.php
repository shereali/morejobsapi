<?php

namespace Database\Seeders;

use App\Models\JobNature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class JobNatureSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        JobNature::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Full time', 'view_order' => 1],
            ['title' => 'Part time', 'view_order' => 2],
            ['title' => 'Contractual', 'view_order' => 3],
            ['title' => 'Internship', 'view_order' => 4],
        ];

        JobNature::insert($data);
    }
}
