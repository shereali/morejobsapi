<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Validation\UnauthorizedException;

class HasCompany
{
    public function handle($request, Closure $next)
    {
        $company = AuthService::getAuthUser()
            ->companies()
            //->where('companies.slug', $request->company_slug)
            ->first();

        if (empty($company)) {
            throw new UnauthorizedException('Forbidden action. This company not activated yet. Please contact with admin', 403);
        }

        define('COMPANY_ID', $company->id);

        return $next($request);
    }
}
