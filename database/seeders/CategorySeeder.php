<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title_en' => 'Accounting/Finance', 'slug' => 'accounting-finance', 'title_bn' => 'অ্যাকাউন্টিং ও ফাইন্যান্স', 'category_type_id' => 1, 'tag_id' => 1],
            ['title_en' => 'Education/Course', 'slug' => 'education-training', 'title_bn' => 'শিক্ষা / প্রশিক্ষণ', 'category_type_id' => 1, 'tag_id' => 1],
            ['title_en' => 'Design/Creative', 'slug' => 'design-creative', 'title_bn' => 'ডিজাইন / ক্রিয়েটিভ', 'category_type_id' => 1, 'tag_id' => 1],
            ['title_en' => 'IT Telecommunication', 'slug' => 'IT-telecommunication', 'title_bn' => 'আইটি টেলিযোগাযোগ', 'category_type_id' => 1, 'tag_id' => 1],
            ['title_en' => 'Medical/Pharma', 'slug' => 'medical-pharma', 'title_bn' => 'মেডিকেল / ফার্মা', 'category_type_id' => 1, 'tag_id' => 1],


            ['title_en' => 'Agro based Industry', 'slug' => 'agro_based_industry', 'title_bn' => 'কৃষি ভিত্তিক শিল্প', 'category_type_id' => 2, 'tag_id' => 2],
            ['title_en' => 'Education', 'slug' => 'education', 'title_bn' => 'শিক্ষা', 'category_type_id' => 2, 'tag_id' => 2],
            ['title_en' => 'Pharmaceuticals', 'slug' => 'pharmaceuticals', 'title_bn' => 'ফার্মাসিউটিক্যালস', 'category_type_id' => 2, 'tag_id' => 2],
            ['title_en' => 'Logistics/ Transportation', 'slug' => 'logistics_Transportation', 'title_bn' => '', 'category_type_id' => 2, 'tag_id' => 2],
            ['title_en' => 'Hotel/Restaurant', 'slug' => 'hotel_Restaurant', 'title_bn' => '', 'category_type_id' => 2, 'tag_id' => 2],
        ];

        Category::insert($data);
    }
}
