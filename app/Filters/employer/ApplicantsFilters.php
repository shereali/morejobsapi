<?php

namespace App\Filters\employer;

use App\Filters\QueryFilters;
use App\Services\HelperService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicantsFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function status($value)
    {
        if ($value == 'all') {
            $this->builder;
        } elseif ($value == 'viewed') {
            $this->builder->where('is_viewed', 1);
        } elseif ($value == 'not_viewed') {
            $this->builder->where('is_viewed', 0);
        } elseif ($value == 'short_list') {
            $this->builder->where('status', 1);
        } elseif ($value == 'interview_list') {
            $this->builder->where('status', 2);
        } elseif ($value == 'final_list') {
            $this->builder->where('status', 3);
        } elseif ($value == 'rejected') {
            $this->builder->where('status', 6);
        }
    }

    public function applicant_name($value)
    {
        $searchWordArray = HelperService::extractKeywords($value);
        $this->builder->whereHas('user', function ($q) use ($value, $searchWordArray) {
            $q->where(function ($q) use ($searchWordArray) {
                foreach ($searchWordArray as $item) {
                    $q->orWhere('first_name', 'LIKE', "%$item%");
                    $q->orWhere('last_name', 'LIKE', "%$item%");
                }
            });
        });
    }

    public function age_from($value)
    {
        $startDob = Carbon::now()->subYears($value)->toDateString();

        $this->builder->whereHas('user', function ($q) use ($startDob) {
            $q->whereHas('profile', function ($q) use ($startDob) {
                $q->where('dob', '>=', $startDob);
            });
        });
    }

    public function age_to($value)
    {
        $startDob = Carbon::now()->subYears($value)->toDateString();

        $this->builder->whereHas('user', function ($q) use ($startDob) {
            $q->whereHas('profile', function ($q) use ($startDob) {
                $q->where('dob', '<=', $startDob);
            });
        });
    }

    public function gender($value)
    {
        $this->builder->whereHas('user', function ($q) use ($value) {
            $q->whereHas('profile', function ($q) use ($value) {
                $q->whereGenderId($value);
            });
        });
    }

    public function job_level($value)
    {
        $this->builder->whereHas('user', function ($q) use ($value) {
            $q->whereHas('profile', function ($q) use ($value) {
                $q->whereJobLevelId($value);
            });
        });
    }

    public function area_ids($value)
    {
        $areaIds = $value ? explode(',', $value) : [];

        $this->builder->whereHas('user', function ($q) use ($areaIds) {
            $q->whereHas('profile', function ($q) use ($areaIds) {
                if ($this->request->location_type == 'inside_bd') {
                    if (($this->request->present_address && $this->request->permanent_address) || (!$this->request->present_address && !$this->request->permanent_address)) {
                        $q->whereHas('presentArea', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('presentArea.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('presentArea.parent.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        });
                        $q->orWhereHas('permanentArea', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('permanentArea.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('permanentArea.parent.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        });
                    } elseif ($this->request->present_address) {
                        $q->whereHas('presentArea', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('presentArea.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('presentArea.parent.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        });
                    } elseif ($this->request->permanent_address) {
                        $q->whereHas('permanentArea', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('permanentArea.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        })->orWhereHas('permanentArea.parent.parent', function ($q) use ($areaIds) {
                            $q->where('level', 1)->whereIn('id', $areaIds);
                        });
                    }
                } else {
                    if ($this->request->present_address && $this->request->permanent_address) {
                        $q->whereIn('permanent_area_id', $areaIds)->orWhereIn('permanent_area_id', $areaIds);
                    } elseif ($this->request->present_address) {
                        $q->whereIn('permanent_area_id', $areaIds);
                    } elseif ($this->request->permanent_address) {
                        $q->whereIn('permanent_area_id', $areaIds);
                    }
                }

            });
        });
    }


    public function salary_from($value)
    {
        $this->builder->where('expected_salary', '>=', $value);
    }

    public function salary_to($value)
    {
        $this->builder->where('expected_salary', '<=', $value);
    }

    public function search_by($value)
    {
        $this->builder->whereHas('user', function ($q) use ($value) {
            $q->where(function ($q) use ($value) {
                $q->where('first_name', 'like', "%$value%")->orWhere('last_name', 'like', "%$value%");
            })->orWhereHas('contacts', function ($q) use ($value) {
                $q->where('title', 'like', "%$value%");
            });
        });
    }

    public function degree_level($value)
    {
        $this->builder->whereHas('user.educations', function ($q) use ($value) {
            $q->where('education_level_id', $value);
        });
    }

    public function degree($value)
    {
        $this->builder->whereHas('user.educations', function ($q) use ($value) {
            $q->where('degree_id', $value);
        });
    }

//    public function institutes($value)
//    {
//        $ids = $value ? explode(',', $value) : [];
//
//        $this->builder->whereHas('user.educations', function ($q) use ($value){
//            $q->where(function ($q) use ($value) {
//                $q->where('degree_id', $value);
//            });
//        });
//    }

    public function major($value)
    {
        $this->builder->whereHas('user.educations', function ($q) use ($value) {
            $q->where('major', $value);
        });
    }

    public function result_type($value)
    {
        $this->builder->whereHas('user.educations', function ($q) use ($value) {
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

    public function matching_criteria($value)
    {
        if (request()->has('is_custom_matching_criteria') && request()->is_custom_matching_criteria) {
            $this->builder->having('matched_percentage', $value);
        } else {
            $this->builder->having('matched_percentage', '>=', $value);
        }
    }

    public function business_organizations($value)
    {
        $businessOrgs = $value ? explode(',', $value) : [];

        $this->builder->whereHas('user.jobExperiences', function ($q) use ($businessOrgs) {
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
