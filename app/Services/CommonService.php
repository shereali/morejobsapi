<?php

namespace App\Services;

use App\Models\Area;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Company;
use App\Models\CompanyContactPerson;
use App\Models\Country;
use App\Models\Degree;
use App\Models\EducationLevel;
use App\Models\Gender;
use App\Models\IndustryType;
use App\Models\Institute;
use App\Models\JobLevel;
use App\Models\JobListingType;
use App\Models\JobNature;
use App\Models\MaritalStatus;
use App\Models\MatchingCriteria;
use App\Models\OrganizationType;
use App\Models\PackageGroup;
use App\Models\Religion;
use App\Models\ResultType;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\TrainingCategory;
use App\Models\TrainingType;
use App\Models\Workspace;
use Illuminate\Support\Facades\DB;

class CommonService
{
    public static function jobCategoryTypes()
    {
        return CategoryType::get();
    }

    public static function jobCategories($type = '')
    {
        return Category::when($type == 'functional', function ($q) {
            $q->where('category_type_id', 1)->where('tag_id', 1);
        }, function ($q) use ($type) {
            $q->when($type === 'special_skill', function ($q) {
                $q->where('category_type_id', 2);
            });
        })
            ->orderBy('title_en', 'ASC')
            ->get();
    }

    public static function districtsInside()
    {
        $data = Area::select(DB::raw("CONCAT(areas.title_en, ' -> ', child.title_en) AS title"), 'child.id', 'child.country_id')
            ->whereNull('areas.parent_id')
            ->join('areas as child', 'child.parent_id', 'areas.id')
            ->orderBy('areas.title_en', 'ASC')
            ->get();

        return $data;
    }

    public static function districts()
    {
        return Area::select('id', 'title_en')
            ->whereNotNull('parent_id')
            ->whereLevel(1)
            ->orderBy('title_en', 'ASC')
            ->get();
    }

    public static function areas()
    {
        return Area::orderBy('title_en', 'ASC')->get();
    }

    public static function divisions()
    {
        return Area::select('id', 'title_en AS title', 'country_id')
            ->whereNull('parent_id')
            ->orderBy('title_en', 'ASC')
            ->get();
    }

    public static function countriesExceptBD()
    {
        return Country::where('id', '!=', 1)->get();
    }

    public static function industryTypes($max = null)
    {
        return IndustryType::when($max, function ($q) use ($max) {
            $q->take($max);
        })
            ->whereNotNull('parent_id')
            ->orderBy('title_en', 'ASC')
            ->get();
    }

    public static function industryTypeWithChild()
    {
        return IndustryType::whereNull('parent_id')->with('subIndustryTypes')->orderBy('title_en', 'ASC')->get();
    }

    public static function organizationTypes()
    {
        return OrganizationType::select('id', 'title_en', 'title_bn')->orderBy('title_en', 'ASC')->get();
    }

    public static function genders()
    {
        return Gender::get();
    }

    public static function religions()
    {
        return Religion::get();
    }

    public static function maritalStatus()
    {
        return MaritalStatus::get();
    }

    public static function countries($max = null)
    {
        return Country::when($max, function ($q) use ($max) {
            $q->take($max);
        })->get();
    }

    public static function jobLevels()
    {
        return JobLevel::get();
    }

    public static function jobNatures()
    {
        return JobNature::select('id', 'title')->get();
    }

    public static function educationLevels()
    {
        return EducationLevel::get();
    }

    public static function resultTypes()
    {
        return ResultType::get();
    }

    public static function degrees()
    {
        return Degree::get();
    }

    public static function institutes()
    {
        return Institute::select('id', 'title')->get();
    }

    public static function skills()
    {
        return Skill::get();
    }

    public static function serviceTypes()
    {
        return PackageGroup::with('packages')
            ->wherePackageTypeId(1)
            ->get()
            ->pluck('packages')
            ->collapse();
    }

    public static function resumeReceiveOptions(): array
    {
        return [
            'option_1' => [
                ['title' => 'Apply Online']
            ],
            'option_2' => [
                ['title' => 'Email', 'value' => 'email'],
                ['title' => 'Hard Copy', 'value' => 'hard_copy'],
                ['title' => 'Walk in Interview', 'value' => 'walk_in_interview'],
            ]
        ];
    }

    public static function workspaces()
    {
        return Workspace::get();
    }

    public static function salaryTypes()
    {
        return [
            ['id' => 1, 'title' => 'Hourly'],
            ['id' => 2, 'title' => 'Daily'],
            ['id' => 3, 'title' => 'Monthly'],
            ['id' => 4, 'title' => 'Yearly'],
        ];
    }

    public static function companyContactPersons()
    {
        return CompanyContactPerson::whereCompanyId(COMPANY_ID)->get();
    }

    public static function postMatchingCriteria()
    {
        return MatchingCriteria::get();
    }


    public static function benefits()
    {
        return [
            'benefit_options' => [
                ['id' => 1, 'title' => 'T/A'],
                ['id' => 2, 'title' => 'Mobile Bill'],
                ['id' => 3, 'title' => 'Pension Policy'],
                ['id' => 4, 'title' => 'Tour Allowance'],
                ['id' => 5, 'title' => 'Credit Card'],
                ['id' => 6, 'title' => 'Medical Allowance'],
                ['id' => 7, 'title' => 'Performance Bonus'],
                ['id' => 8, 'title' => 'Profit Share'],
                ['id' => 9, 'title' => 'Provident Fund'],
                ['id' => 10, 'title' => 'Weekly 2 Holidays'],
                ['id' => 11, 'title' => 'Insurance'],
                ['id' => 12, 'title' => 'Overtime Allowance'],
            ],
            'lunch_facility_options' => [
                ['id' => 1, 'title' => 'Partially Subsidize'],
                ['id' => 2, 'title' => 'Full Subsidize'],
                ['id' => 0, 'title' => 'NA'],
            ],
            'salary_review_options' => [
                ['id' => 1, 'title' => 'Half Yearly'],
                ['id' => 2, 'title' => 'Yearly'],
                ['id' => 0, 'title' => 'NA'],
            ],
            'festival_bonus_options' => [
                ['id' => 1, 'title' => '1'],
                ['id' => 2, 'title' => '2'],
                ['id' => 3, 'title' => '3'],
                ['id' => 4, 'title' => '4'],
            ]
        ];
    }

    public static function jobListingTypes()
    {
        return JobListingType::select('id', 'title')->get();
    }

    public static function systemCreatedCompanies()
    {
        return Company::select('id', 'title_en', 'title_bn', 'organization_type_id')->where('created_by', 1)->whereStatus(1)->get();
    }

    public static function tags()
    {
        return Tag::get();
    }

    public static function trainingTypes()
    {
        return TrainingType::orderBy('title', 'ASC')->get();
    }

    public static function trainingCategories()
    {
        return TrainingCategory::orderBy('title', 'ASC')->get();
    }
}
