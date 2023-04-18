<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(IndustryTypeSeeder::class);
        $this->call(CategoryTypeSeeder::class);
        $this->call(ServiceTypeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(MaritalStatusSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(JobLevelSeeder::class);
        $this->call(JobNatureSeeder::class);
        $this->call(EducationLevelSeeder::class);
        $this->call(ResultTypeSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(WorkspaceSeeder::class);
        $this->call(JoblistingTypeSeeder::class);
        $this->call(InstituteSeeder::class);
        $this->call(MatchingCriteriaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(OrganizationTypeSeeder::class);
        $this->call(TrainingTypeSeeder::class);
        $this->call(TrainingCategorySeeder::class);
        $this->call(AdsPositionSeeder::class);
    }
}
