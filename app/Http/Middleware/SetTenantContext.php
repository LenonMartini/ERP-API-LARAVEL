<?php

namespace App\Http\Middleware;

use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetTenantContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            // ⚠️ NÃO carregar relações aqui
            TenantContext::set(
                $user->tenant_id,
                $user->type
            );
        }

        return $next($request);
    }
}
