<?php

namespace App\Models;

use App\Services\StaticValueService;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use Filterable;

    protected $guarded = ['id'];


    public function organizationType()
    {
       return $this->belongsTo(OrganizationType::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(CompanyContact::class);
    }

    public function contactPersons(): HasMany
    {
        return $this->hasMany(CompanyContactPerson::class);
    }

    public function defaultContact()
    {
        return $this->hasOne(CompanyContact::class)->whereIsDefault(1);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Post::class, 'company_id', 'id');
    }

    public function industryTypes()
    {
        return $this->belongsToMany(IndustryType::class, 'company_industry', 'company_id', 'industry_type_id');
    }

    public function getStatusAttribute($value): array
    {
        return StaticValueService::companyStatusById($value);
    }

    public static function getLogoAttribute($value): ?string
    {
        return $value ? asset('uploads/'.$value) : null;
    }
}
