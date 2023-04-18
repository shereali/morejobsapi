<?php


namespace App\Filters\Home;

use App\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryWiseJobFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function category($value)
    {
        if ($value == 'all_cat') {
            return $this->builder;

        } elseif ($value == 'all_cat_fun') {
            return $this->builder->whereHas('category', function ($q) {
                $q->where('category_type_id', 1);
            });
        } elseif ($value == 'all_cat_special') {
            return $this->builder->whereHas('category', function ($q) {
                $q->where('category_type_id', 2);
            });
        }

        $this->builder->whereCategoryId($value);
    }

    public function area_id($value)
    {
        $this->builder->where(function ($q) use ($value) {
            $q->whereHas('postAreas', function ($q) use ($value) {
                $q->where('areas.id', $value)->orWhere('parent_id', $value);
            })
//                ->orWhereHas('postAreas', function ($q) {
//                return $q;
//            }, '<', 1) // for any where bd
            ;
        });
    }

    public function search_value($value)
    {
        $this->builder->where('title', 'like', "%$value%");
    }

    public function organization_type_id($value)
    {
        $this->builder->whereHas('company', function ($q) use ($value) {
            $q->whereOrganizationTypeId($value);
        });

        if ($value == 1){
            $this->builder->where('job_listing_type_id', 4);
        }
    }

    public function industry_type_id($value)
    {
        $this->builder->whereHas('postIndustryTypes', function ($q) use ($value) {
            $q->where('industry_types.id', $value);
        });
    }

    public function post_within($value)
    {
        $data = null;

        if ($value == 'today') {
            $data = Carbon::now();
        } elseif ($value == 'last_2_days') {
            $data = Carbon::now()->subDays(2);
        } elseif ($value == 'last_3_days') {
            $data = Carbon::now()->subDays(3);
        } elseif ($value == 'last_4_days') {
            $data = Carbon::now()->subDays(4);
        } elseif ($value == 'last_5_days') {
            $data = Carbon::now()->subDays(5);
        }

        if ($data) {
            return $this->builder->whereDate('created_at', '>=', $data->toDateString());
        }
        return $this->builder;
    }

    public function deadline($value)
    {
        $data = null;

        if ($value == 'today') {
            $data = Carbon::now();
        } elseif ($value == 'tomorrow') {
            $data = Carbon::now()->addDay();
        } elseif ($value == 'next_2_days') {
            $data = Carbon::now()->addDays(2);
        } elseif ($value == 'next_3_days') {
            $data = Carbon::now()->addDays(3);
        } elseif ($value == 'next_4_days') {
            $data = Carbon::now()->addDays(5);
        }

        if ($data) {
            return $this->builder->whereDate('deadline', $data->toDateString());
        }
        return $this->builder;
    }

    public function exp_range($value)
    {
        if ($value == 'below_1_year') {
            $this->builder->where('experience_max', '<=', 1);
        } elseif ($value == '1_to_3') {
            $this->builder->where('experience_min', '>=', 1)->where('experience_max', '<=', 3);
        } elseif ($value == '3_to_5') {
            $this->builder->where('experience_min', '>=', 3)->where('experience_max', '<=', 5);
        } elseif ($value == '5_to_10') {
            $this->builder->where('experience_min', '>=', 5)->where('experience_max', '<=', 10);
        } elseif ($value == 'over_10_years') {
            $this->builder->where('experience_min', '>', 10);
        }
    }

    public function age_range($value)
    {
        if ($value == 'below_20_years') {
            $this->builder->where('age_max', '<=', 20);
        } elseif ($value == '20_to_30') {
            $this->builder->where('age_min', '>=', 20)->where('age_max', '<=', 30);
        } elseif ($value == '30_to_40') {
            $this->builder->where('age_min', '>=', 30)->where('age_max', '<=', 40);
        } elseif ($value == '40_to_50') {
            $this->builder->where('age_min', '>=', 40)->where('age_max', '<=', 50);
        } elseif ($value == 'over_50_years') {
            $this->builder->where('age_min', '>', 50);
        }
    }

    public function work_from_home($value)
    {
        if ($value == true) {
            $this->builder->whereHas('postWorkspaces', function ($q) {
                $q->where('post_workspace.workspace_id', 1);
            });
        }
    }

    public function job_nature($value)
    {
        $this->builder->whereHas('postNatures', function ($q) use ($value) {
            $q->where('post_nature.job_nature_id', $value);
        });
    }

    public function job_level($value)
    {
        $this->builder->whereHas('postLevels', function ($q) use ($value) {
            $q->where('post_level.job_level_id', $value);
        });
    }

    public function g_male($value)
    {
        if ($value == true) {
            $this->builder->whereHas('postGenders', function ($q) {
                $q->where('post_gender.gender_id', 1);
            });
        }
    }

    public function g_female($value)
    {
        if ($value == true) {
            $this->builder->whereHas('postGenders', function ($q) {
                $q->where('post_gender.gender_id', 2);
            });
        }
    }

    public function g_other($value)
    {
        if ($value == true) {
            $this->builder->whereHas('postGenders', function ($q) {
                $q->where('post_gender.gender_id', 3);
            });
        }
    }

    public function sort($value)
    {
//        $data = HelperService::getSortKeyVal($value);
//        $sortType = $data->sort_type;
//
//        if ($sortType) {
//            if ($data->sort_key == 'title_en') {
//                $this->builder->orderBy('title_en', $sortType);
//            } elseif ($data->sort_key == 'title_bn') {
//                $this->builder->orderBy('title_bn', $sortType);
//            } elseif ($data->sort_key == 'updated_at') {
//                $this->builder->orderBy('updated_at', $sortType);
//            }
//        }
    }
}
