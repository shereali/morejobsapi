<?php

namespace Database\Seeders;

use App\Models\JobListingType;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class JoblistingTypeSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        JobListingType::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Regular'],
            ['title' => 'Hot job'],
            ['title' => 'Tender/EOI'],
            ['title' => 'Govt job'],
        ];

        JobListingType::insert($data);
    }
}
