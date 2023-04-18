<?php

namespace Database\Seeders;

use App\Models\ResultType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ResultTypeSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ResultType::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'First Division/Class'],
            ['title' => 'Second Division/Class'],
            ['title' => 'Third Division/Class'],
            ['title' => 'Grade'],
            ['title' => 'Appeared'],
            ['title' => 'Enrolled'],
            ['title' => 'Award'],
            ['title' => 'Do not mention'],
            ['title' => 'Pass'],
        ];

        ResultType::insert($data);
    }
}
