<?php

namespace App\Models;

use App\Services\StaticValueService;
use App\Traits\Filterable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens, Filterable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'account_verification_token'
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function contactEmails(): HasMany
    {
        return $this->hasMany(UserContact::class)->whereType(StaticValueService::userContactTypeId('email'));
    }

    public function contactMobiles(): HasMany
    {
        return $this->hasMany(UserContact::class)->whereType(StaticValueService::userContactTypeId('mobile'));
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(UserContact::class)->select('id', 'title', 'type', 'is_verified');
    }

    public function defaultContact()
    {
        return $this->hasOne(UserContact::class)->whereIsDefault(1);
    }

    public function trainings()
    {
        return $this->hasMany(UserTraining::class);
    }

    public function preferredOrganizationTypes()
    {
        return $this->belongsToMany(IndustryType::class, 'user_industry_type', 'user_id', 'industry_type_id');
    }

    public function preferredAreas()
    {
        return $this->belongsToMany(Area::class, 'user_job_area', 'user_id', 'area_id');
    }

    public function preferredJobCategories()
    {
        return $this->belongsToMany(Category::class, 'user_job_category', 'user_id', 'category_id');
    }

    public function specializations()
    {
        return $this->belongsToMany(Skill::class, 'user_skill_keyword', 'user_id', 'skill_id');
    }

    public function languageProficiencies(): HasMany
    {
        return $this->hasMany(UserLanguage::class, 'user_id', 'id');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(UserCertification::class, 'user_id', 'id');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(UserAcademic::class, 'user_id', 'id');
    }

    public function jobExperiences(): HasMany
    {
        return $this->hasMany(UserExperience::class, 'user_id', 'id');
    }

    public function onlineApplications()
    {
        return $this->belongsToMany(Post::class, 'post_applicants', 'user_id', 'post_id')
            ->withPivot('status', 'is_viewed', 'created_at');
    }

    public function favCompanies()
    {
        return $this->belongsToMany(Company::class, 'user_fav_company', 'user_id', 'company_id');
    }

    public function favPosts()
    {
        return $this->belongsToMany(Post::class, 'user_fav_post', 'user_id', 'post_id');
    }

    public function userSkills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill', 'user_id', 'skill_id');
    }

    public function references()
    {
        return $this->hasMany(UserReference::class, 'user_id');
    }

//    public function companyOwner()
//    {
//        return $this->belongsToMany(Company::class, 'company_user', 'user_id', 'company_id')
//            ->wherePivot('user_type', 1)
//            ->wherePivot('status', 1)
//            ->where('companies.status', 1)
//            ->select('companies.id', 'title_en', 'title_bn');
//    }
//
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_user', 'user_id', 'company_id')
            //->wherePivot('status', 1)
            //->where('companies.status', 1)
            ;
    }


    public function findForPassport($username)
    {
        return $this->where('username', $username)
            ->whereStatus(1)
            ->first();
    }

    public function getStatusAttribute($value): array
    {
        return StaticValueService::userStatusById($value);
    }

    public function getImageAttribute($value): ?string
    {
        if ($value) {
            return asset("/uploads/$value");
        }
        return null;
    }

    public function getUserTypeAttribute($value): array
    {
        return StaticValueService::userTypeById($value);
    }

    public function getRegMediumAttribute($value): array
    {
        return StaticValueService::regMediumById($value);
    }
}
