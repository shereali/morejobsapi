<?php

namespace Database\Seeders;

use App\Models\IndustryType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class IndustryTypeSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        IndustryType::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'title_en' => 'Agro based Industry',
                'title_bn' => 'কৃষি ভিত্তিক শিল্প',
                'childs' => [
                    ['title_en' => 'Agro based firms (incl. Agro Processing/Seed/GM)', 'title_bn' => ''],
                    ['title_en' => 'Animal/Plant Breeding', 'title_bn' => ''],
                    ['title_en' => 'Dairy', 'title_bn' => ''],
                    ['title_en' => 'Hatchery', 'title_bn' => ''],
                    ['title_en' => 'Farming', 'title_bn' => ''],
                    ['title_en' => 'Fisheries', 'title_bn' => ''],
                    ['title_en' => 'Poultry', 'title_bn' => ''],
                    ['title_en' => 'Science Laboratory', 'title_bn' => ''],
                    ['title_en' => 'Tea Garden', 'title_bn' => ''],
                    ['title_en' => 'Salt', 'title_bn' => ''],
                    ['title_en' => 'Livestock', 'title_bn' => ''],
                    ['title_en' => 'Shrimp', 'title_bn' => ''],
                    ['title_en' => 'Reptile Firms', 'title_bn' => ''],
                ]
            ],
            [
                'title_en' => 'Airline/Travel/Tourism',
                'title_bn' => '',
                'childs' => [
                    ['title_en' => 'Airline', 'title_bn' => ''],
                    ['title_en' => 'Tour Operator', 'title_bn' => ''],
                    ['title_en' => 'GSA', 'title_bn' => ''],
                    ['title_en' => 'Transport Service', 'title_bn' => ''],
                    ['title_en' => 'Immigration/Visa Processing', 'title_bn' => ''],
                    ['title_en' => 'Travel Agent', 'title_bn' => ''],
                ]
            ],
            [
                'title_en' => 'Architecture/ Engineering/ Construction', 'title_bn' => 'আর্কিটেকচার / ইঞ্জিনিয়ারিং / নির্মাণ',
                'childs' => [
                    ['title_en' => 'Architecture Firm', 'title_bn' => ''],
                    ['title_en' => 'HVAC System', 'title_bn' => ''],
                    ['title_en' => 'Engineering Firms', 'title_bn' => ''],
                    ['title_en' => 'Interior Design', 'title_bn' => ''],
                    ['title_en' => 'Escalator/Elevator/Lift', 'title_bn' => ''],
                ]
            ],
            ['title_en' => 'Bank/ Non-Bank Fin. Institution', 'title_bn' => 'ব্যাংক / নন-ব্যাংক ফিন. প্রতিষ্ঠান', 'childs' => [

            ]
            ],
            ['title_en' => 'Education', 'title_bn' => 'শিক্ষা', 'childs' => [

            ]
            ],
            ['title_en' => 'Software Company', 'title_bn' => 'সফটওয়্যার কোম্পানি', 'childs' => [

            ]
            ],
        ];


        foreach ($data as $item) {
            $x = IndustryType::create(collect($item)->only('title_en', 'title_bn')->toArray());

            foreach ($item['childs'] as $item2) {
                IndustryType::create(collect($item2)->only('title_en', 'title_bn')->toArray() + [
                        'parent_id' => $x->id
                    ]);
            }
        }
    }
}
