<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SkillSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Skill::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'PHP'],
            ['title' => 'Angular'],
            ['title' => 'Laravel'],
            ['title' => 'React'],
            ['title' => 'Python'],
            ['title' => 'Accounting'],
            ['title' => 'Analysis'],
        ];

        Skill::insert($data);
    }
}
