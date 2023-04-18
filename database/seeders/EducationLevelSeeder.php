<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\EducationLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EducationLevelSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        EducationLevel::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'PSC/5 pass', 'view_order' => 1],
            ['title' => 'JSC/JDC/8 pass', 'view_order' => 2],
            ['title' => 'Secondary', 'view_order' => 3],
            ['title' => 'Higher Secondary', 'view_order' => 4],
            ['title' => 'Diploma', 'view_order' => 5],
            ['title' => 'Bachelor/Honors', 'view_order' => 6],
            ['title' => 'Masters', 'view_order' => 7],
            ['title' => 'PhD (Doctor of Philosophy)', 'view_order' => 8],
        ];

        EducationLevel::insert($data);


        Schema::disableForeignKeyConstraints();
        Degree::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'PSC', 'education_level_id' => 1, 'major_required' => 0, 'view_order' => 1],
            ['title' => 'Ebtedayee (Madrasah)', 'education_level_id' => 1, 'major_required' => 0, 'view_order' => 2],
            ['title' => '5 Pass', 'education_level_id' => 1, 'major_required' => 0, 'view_order' => 3],

            ['title' => 'JSC', 'education_level_id' => 2, 'major_required' => 0, 'view_order' => 4],
            ['title' => 'JDC (Madrasah)', 'education_level_id' => 2, 'major_required' => 0, 'view_order' => 5],
            ['title' => '8 Pass', 'education_level_id' => 2, 'major_required' => 0, 'view_order' => 6],

            ['title' => 'SSC', 'education_level_id' => 3, 'major_required' => 1, 'view_order' => 7],
            ['title' => 'O Level', 'education_level_id' => 3, 'major_required' => 1, 'view_order' => 8],
            ['title' => 'Dakhil (Madrasah)', 'education_level_id' => 3, 'major_required' => 1, 'view_order' => 9],
            ['title' => 'SSC (Vocational)', 'education_level_id' => 3, 'major_required' => 1, 'view_order' => 10],

            ['title' => 'HSC', 'education_level_id' => 4, 'major_required' => 1, 'view_order' => 7],
            ['title' => 'A Level', 'education_level_id' => 4, 'major_required' => 1, 'view_order' => 8],
            ['title' => 'Alim (Madrasah)', 'education_level_id' => 4, 'major_required' => 1, 'view_order' => 9],
            ['title' => 'HSC (Vocational)', 'education_level_id' => 4, 'major_required' => 1, 'view_order' => 10],

            ['title' => 'Diploma in Engineering', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 7],
            ['title' => 'Diploma in Medical Technology', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 8],
            ['title' => 'Diploma in Nursing', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 9],
            ['title' => 'Diploma in Commerce', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Business Studies', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Post Graduate Diploma (PGD)', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Pathology', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma (Vocational)', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Hotel Management', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Computer', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Mechanical', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Refrigeration and air Conditioning', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Electrical', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Automobile', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Power', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Electronics', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Architecture', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Electro medical', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Civil', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Marine', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Diploma in Medical', 'education_level_id' => 5, 'major_required' => 1, 'view_order' => 10],

            ['title' => 'Bachelor degree in any discipline', 'education_level_id' => 6, 'major_required' => 0, 'view_order' => 10],
            ['title' => 'Bachelor of Science (BSc)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Arts (BA)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Commerce (BCom)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Commerce (Pass)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Business Administration (BBA)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Medicine and Bachelor of Surgery(MBBS)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Dental Surgery (BDS)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Architecture (B.Arch)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Pharmacy (B.Pharm)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Education (B.Ed)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Physical Education (BPEd)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Law (LLB)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Doctor of Veterinary Medicine (DVM)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Social Science (BSS)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Fine Arts (B.F.A)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Business Studies (BBS)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor of Computer Application (BCA)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Fazil (Madrasah)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Bachelor in Engineering (BEngg)', 'education_level_id' => 6, 'major_required' => 1, 'view_order' => 10],

            ['title' => 'Masters degree in any discipline', 'education_level_id' => 7, 'major_required' => 0, 'view_order' => 10],
            ['title' => 'Master of Science (MSc)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Arts (MA)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Commerce (MCom)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Business Administration (MBA)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Architecture (M.Arch)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Pharmacy (M.Pharm)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Education (M.Ed)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Law (LLM)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Social Science (MSS)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Fine Arts (M.F.A)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Philosophy (M.Phil)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Business Management (MBM)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Development Studies (MDS)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Business Studies (MBS)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Masters in Computer Application (MCA)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Executive Master of Business Administration (EMBA)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Fellowship of the College of Physicians and Surgeons (FCPS)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Kamil (Madrasah)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Masters in Engineering (MEngg)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Masters in Bank Management (MBM)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Masters in Information Systems Security (MISS)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],
            ['title' => 'Master of Information & Communication Technology (MICT)', 'education_level_id' => 7, 'major_required' => 1, 'view_order' => 10],

            ['title' => 'PhD', 'education_level_id' => 8, 'major_required' => 1, 'view_order' => 10],
        ];

        Degree::insert($data);
    }
}
