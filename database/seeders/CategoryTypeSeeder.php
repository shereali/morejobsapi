<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategoryTypeSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('category_types')->truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title_en' => 'Functional Category', 'title_bn' => 'কার্যকরী'],
            ['title_en' => 'Special Skilled Category', 'title_bn' => 'স্পেশাল স্কিল্‌ড'],
        ];

        DB::table('category_types')->insert($data);
    }
}
