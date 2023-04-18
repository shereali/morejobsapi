<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TagSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Tag::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title_en' => 'Functional', 'title_bn' => 'কার্যকরী'],
            ['title_en' => 'Industrial', 'title_bn' => 'শিল্প'],
        ];

        Tag::insert($data);
    }
}
