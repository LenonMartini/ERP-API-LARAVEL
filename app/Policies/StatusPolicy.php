<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;

class StatusPolicy
{
    protected function isSystem(User $user): bool
    {
        return $user->type === 'SYSTEM';
    }

    protected function sameTenant(User $user, Status $status): bool
    {
        $const = $user->tenants()
            ->where('tenant_id', $status->tenant_id)
            ->exists();

        return $const;
    }

    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $authUser): bool
    {

        // system não acessa ERP
        if ($authUser->type === 'SYSTEM') {
            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    public function view(User $authUser, Status $status): bool
    {

        if ($authUser->type === 'SYSTEM') {
            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(User $authUser): bool
    {
        if ($authUser->type === 'SYSTEM') {
            return false;
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(User $authUser, Status $status): bool
    {
        if ($authUser->type === 'SYSTEM') {
            return false;
        }

        return $this->sameTenant($authUser, $status);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(User $authUser, Status $status): bool
    {
        if ($authUser->type === 'SYSTEM') {
            return false;
        }

        return $this->update($authUser, $status);
    }
}
