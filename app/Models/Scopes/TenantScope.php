<?php

namespace App\Models\Scopes;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Contexto ainda não pronto (login, seed, console)
        if (! TenantContext::ready()) {
            return;
        }

        // SYSTEM vê tudo
        if (TenantContext::isSystem()) {
            return;
        }

        // Sem tenant
        if (! TenantContext::tenantId()) {
            return;
        }

        $builder->where(
            $model->getTable().'.tenant_id',
            TenantContext::tenantId()
        );
    }
}
