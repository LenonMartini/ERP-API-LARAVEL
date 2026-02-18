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

        if (! TenantContext::ready()) {
            return;
        }

        $table = $model->getTable();

        // 🔵 SYSTEM logado
        if (TenantContext::isSystem()) {

            if ($model instanceof \App\Models\User) {
                $builder->where($table.'.type', 'SYSTEM');
            }

            return;
        }

        // 🟢 TENANT logado
        if (TenantContext::tenantId()) {

            if ($model instanceof \App\Models\User) {
                $builder->where($table.'.type', 'TENANT');
            }

            $builder->where(
                $table.'.tenant_id',
                TenantContext::tenantId()
            );
        }

    }
}
