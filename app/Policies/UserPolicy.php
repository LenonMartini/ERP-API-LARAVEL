<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    protected function isSystem(User $user): bool
    {
        return $user->type === 'SYSTEM';
    }

    protected function isTenant(User $user): bool
    {
        return $user->type === 'TENANT';
    }

    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $authUser): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    public function view(User $authUser, User $targetUser): bool
    {
        // 🔵 SYSTEM só vê SYSTEM
        if ($this->isSystem($authUser)) {
            return $targetUser->type === 'SYSTEM';
        }

        // 🟢 TENANT nunca vê system
        if ($targetUser->type === 'SYSTEM') {
            return false;
        }

        return $authUser->tenant_id === $targetUser->tenant_id;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(User $authUser): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(User $authUser, User $targetUser): bool
    {
        // SYSTEM só altera SYSTEM
        if ($this->isSystem($authUser)) {
            return $targetUser->type === 'SYSTEM';
        }

        // TENANT nunca altera system
        if ($targetUser->type === 'SYSTEM') {
            return false;
        }

        return $authUser->tenant_id === $targetUser->tenant_id;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(User $authUser, User $targetUser): bool
    {
        return $this->update($authUser, $targetUser);
    }
}
