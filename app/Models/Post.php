<?php

namespace App\Models;

use App\Services\StaticValueService;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Post extends Model
{
    use Userstamps, Filterable;

    protected $guarded = ['id'];

    public function applicants()
    {
        return $this->hasMany(PostApplicant::class, 'post_id');
    }

    public function shortListed()
    {
        return $this->hasMany(PostApplicant::class, 'post_id')->where('status', 1);
    }

    public function viewedApplicants()
    {
        return $this->hasMany(PostApplicant::class, 'post_id')->where('is_viewed', 1);
    }
    public function notViewedApplicants()
    {
        return $this->hasMany(PostApplicant::class, 'post_id')->where('is_viewed', 0);
    }

    public function postMatchingCriteria(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PostMatchingCriteria::class, 'post_id');
    }

    public function postMatchingCriteriaMandatory()
    {
        return $this->belongsToMany(MatchingCriteria::class, 'post_matching_criteria', 'post_id', 'matching_criteria_id')
            ->wherePivot('is_mandatory', 1);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function postNatures()
    {
        return $this->belongsToMany(JobNature::class, 'post_nature', 'post_id', 'job_nature_id');
    }

    public function postLevels()
    {
        return $this->belongsToMany(JobLevel::class, 'post_level', 'post_id', 'job_level_id');
    }

    public function postWorkspaces()
    {
        return $this->belongsToMany(Workspace::class, 'post_workspace', 'post_id', 'workspace_id');
    }

    public function postAreas()
    {
        return $this->belongsToMany(Area::class, 'post_area', 'post_id', 'area_id');
    }

    public function postDegrees()
    {
        return $this->belongsToMany(Degree::class, 'post_degree', 'post_id', 'degree_id')
            ->withPivot(['major']);
    }

    public function postInstitutes()
    {
        return $this->belongsToMany(Institute::class, 'post_institute', 'post_id', 'institute_id');
    }

    public function postInstituteTypes()
    {
        return $this->belongsToMany(InstituteType::class, 'post_industry_type', 'post_id', 'industry_type_id');
    }

    public function postGenders()
    {
        return $this->belongsToMany(Gender::class, 'post_gender', 'post_id', 'gender_id');
    }

    public function postTrainings()
    {
        return $this->hasMany(PostTraining::class);
    }

    public function postCertificates()
    {
        return $this->hasMany(PostCertificate::class);
    }

    public function postIndustryTypes()
    {
        return $this->belongsToMany(IndustryType::class, 'post_industry_type', 'post_id', 'industry_type_id');
    }

    public function postCompanyIndustryTypes()
    {
        return $this->belongsToMany(IndustryType::class, 'company_industry', 'company_id', 'industry_type_id', 'company_id');
    }

    public function postAreaExperiences()
    {
        return $this->belongsToMany(Skill::class, 'post_skill', 'post_id', 'skill_id')->wherePivot('type', 1);
    }

    public function postSkills()
    {
        return $this->belongsToMany(Skill::class, 'post_skill', 'post_id', 'skill_id')
            ->wherePivot('type', 2)
            ->withPivot('type');
    }

    public function getStatusAttribute($value): array
    {
        return StaticValueService::postStatusById($value);
    }

    public function getResumeReceivingOptionAttribute($value)
    {
        if ($value) {
            return json_decode($value);
        }
        return null;
    }

    public function getOtherBenefitAttribute($value)
    {
        if ($value) {
            return json_decode($value);
        }
        return null;
    }

    public function getImageAttribute($value)
    {
        return $value ? asset('uploads/'.$value) : null;
    }
}
