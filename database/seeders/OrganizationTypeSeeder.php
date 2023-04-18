<?php

namespace Database\Seeders;

use App\Models\OrganizationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OrganizationTypeSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        OrganizationType::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title_en' => 'Government', 'title_bn' => 'Government'],
            ['title_en' => 'Semi Government', 'title_bn' => 'Semi Government'],
            ['title_en' => 'NGO', 'title_bn' => 'ngo'],
            ['title_en' => 'Private Firm/Company', 'title_bn' => 'Private Firm/Company'],
            ['title_en' => 'Internation Agencies', 'title_bn' => 'Internation Agencies'],
            ['title_en' => 'Others', 'title_bn' => 'Others'],
        ];

        OrganizationType::insert($data);
    }
}
