<?php

namespace App\Models;

use App\Services\StaticValueService;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class PackageSubscription extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    protected $table = 'package_subscription';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function detail()
    {
        return $this->belongsTo(PackageDetail::class, 'package_detail_id');
    }

    public function getStatusAttribute($value)
    {
       return StaticValueService::subscriptionStatusById($value);
    }
}
