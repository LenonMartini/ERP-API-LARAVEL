<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    protected function isSystem(User $user): bool
    {
        return $user->type === 'SYSTEM';
    }

    public function viewAny(User $user): bool
    {
        return $this->isSystem($user);
    }

    public function view(User $user, Tenant $tenant): bool
    {
        return $this->isSystem($user);
    }

    public function create(User $user): bool
    {
        return $this->isSystem($user);
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $this->isSystem($user);
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $this->isSystem($user);
    }
}
