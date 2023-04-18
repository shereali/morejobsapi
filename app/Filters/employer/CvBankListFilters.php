<?php

namespace App\Filters\employer;

use App\Filters\QueryFilters;
use App\Services\HelperService;
use Illuminate\Http\Request;

class CvBankListFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function applicant_name($value)
    {
        $searchWordArray = HelperService::extractKeywords($value);
        $this->builder->where(function ($q) use ($searchWordArray) {
            foreach ($searchWordArray as $item) {
                $q->orWhere('first_name', 'LIKE', "%$item%");
                $q->orWhere('last_name', 'LIKE', "%$item%");
            }
        });
    }

    public function age_from($value)
    {
        $this->builder->having('age', '>=', $value);
    }

    public function age_to($value)
    {
        $this->builder->having('age', '<=', $value);
    }

    public function gender($value)
    {
        $arr = explode(',', $value);
        $this->builder->whereIn('gender_id', $arr);
    }

    public function salary_from($value)
    {
        $this->builder->where('expected_salary', '>=', $value);
    }

    public function salary_to($value)
    {
        $this->builder->where('expected_salary', '<=', $value);
    }

    public function job_level($value)
    {
        $this->builder->whereJobLevelId($value);
    }

    /* public function area_ids($value)
     {
         $areaIds = $value ? explode(',', $value) : [];

         if ($this->request->location_type == 'inside_bd') {
             if (($this->request->present_address && $this->request->permanent_address) || (!$this->request->present_address && !$this->request->permanent_address)) {
                 $this->builder->whereHas('presentArea', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('presentArea.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('presentArea.parent.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 });
                 $this->builder->orWhereHas('permanentArea', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('permanentArea.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('permanentArea.parent.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 });
             } elseif ($this->request->present_address) {
                 $this->builder->whereHas('presentArea', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('presentArea.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('presentArea.parent.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 });
             } elseif ($this->request->permanent_address) {
                 $this->builder->whereHas('permanentArea', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('permanentArea.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 })->orWhereHas('permanentArea.parent.parent', function ($q) use ($areaIds) {
                     $q->where('level', 1)->whereIn('id', $areaIds);
                 });
             }
         } else {
             if ($this->request->present_address && $this->request->permanent_address) {
                 $this->builder->whereIn('permanent_area_id', $areaIds)->orWhereIn('permanent_area_id', $areaIds);
             } elseif ($this->request->present_address) {
                 $this->builder->whereIn('permanent_area_id', $areaIds);
             } elseif ($this->request->permanent_address) {
                 $this->builder->whereIn('permanent_area_id', $areaIds);
             }
         }
     }*/


    public function search_by($value)
    {
        $this->builder->where(function ($q) use ($value) {
            $q->where('first_name', 'like', "%$value%")->orWhere('last_name', 'like', "%$value%");
        })->orWhereHas('contacts', function ($q) use ($value) {
            $q->where('title', 'like', "%$value%");
        });
    }

    public function degree_level($value)
    {
        $this->builder->whereHas('educations', function ($q) use ($value) {
            $q->where('education_level_id', $value);
        });
    }

    public function degree($value)
    {
        $this->builder->whereHas('educations', function ($q) use ($value) {
            $q->where('degree_id', $value);
        });
    }

    public function institutes($value)
    {
        $ids = $value ? explode(',', $value) : [];

        $this->builder->whereHas('educations', function ($q) use ($ids) {
            $q->whereIn('id', $ids);
        });
    }

    public function major($value)
    {
        $this->builder->whereHas('educations', function ($q) use ($value) {
            $q->where('major', $value);
        });
    }

    public function result_type($value)
    {
        $this->builder->whereHas('educations', function ($q) use ($value) {
            $q->where('result_type_id', $value);
        });
    }

    public function title($value)
    {
        $this->builder->where('title', 'like', "%$value%");
    }

    public function experience_from($value)
    {
        $this->builder->having('user_exp_year', '>=', $value);
    }

    public function experience_to($value)
    {
        $this->builder->having('user_exp_year', '<=', $value);
    }

    public function business_organizations($value)
    {
        $businessOrgs = $value ? explode(',', $value) : [];

        $this->builder->whereHas('jobExperiences', function ($q) use ($businessOrgs) {
            $q->whereIn('industry_type_id', $businessOrgs);
        });
    }


    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = $data->sort_type;

//        if ($sortType) {
//            if ($data->sort_key == 'name') {
//                $this->builder->orderBy('title_en', $sortType);
//            } elseif ($data->sort_key == 'contact') {
//                $this->builder->whereHas('contact', function ($q) use ($sortType) {
//                    $q->orderBy('title', $sortType);
//                });
//            } elseif ($data->sort_key == 'status') {
//                $this->builder->orderBy('status', $sortType);
//            } elseif ($data->sort_key == 'created_at') {
//                $this->builder->orderBy('created_at', $sortType);
//            }
//        }
    }
}
