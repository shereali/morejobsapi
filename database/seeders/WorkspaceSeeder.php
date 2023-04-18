<?php

namespace Database\Seeders;

use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WorkspaceSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Workspace::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Work from home'],
            ['title' => 'Work from office'],
        ];

        Workspace::insert($data);
    }
}
