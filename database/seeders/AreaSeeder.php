<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Area::truncate();
        Schema::enableForeignKeyConstraints();

        $areas = DB::table('divisions')->get();
        foreach ($areas as $area) {
            $division = Area::create([
                'title_en' => $area->name,
                'title_bn' => $area->bn_name,
                'slug' => Str::slug($area->name),
                'parent_id' => null,
                'country_id' => 1,
                'level' => 0
            ]);

            $disctricts = DB::table('districts')->where('division_id', $area->id)->get();
            foreach ($disctricts as $area) {
                $district = Area::create([
                    'title_en' => $area->name,
                    'title_bn' => $area->bn_name,
                    'slug' => Str::slug($area->name),
                    'parent_id' => $division->id,
                    'country_id' => 1,
                    'level' => 1
                ]);

                $thanas = DB::table('upazilas')->where('district_id', $area->id)->get();
                foreach ($thanas as $area) {
                     Area::create([
                        'title_en' => $area->name,
                        'title_bn' => $area->bn_name,
                        'slug' => Str::slug($area->name),
                        'parent_id' => $district->id,
                        'country_id' => 1,
                        'level' => 2
                    ]);
                }
            }
        }


        $countries = Country::where('id', '!=', 1)->get();
        foreach ($countries as $country) {
            Area::create([
                'title_en' => $country->title,
                'slug' => Str::slug($country->title),
                'country_id' => $country->id,
                'level' => 0
            ]);
        }


    }
}
