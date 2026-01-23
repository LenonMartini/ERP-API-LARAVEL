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

    /**
     * Listar usuários
     */
    public function viewAny(User $authUser): bool
    {
        return $this->isSystem($authUser) || $this->isTenant($authUser);
    }

    /**
     * Ver usuário específico
     */
    public function view(User $authUser, User $targetUser): bool
    {
        // SYSTEM vê tudo
        if ($this->isSystem($authUser)) {
            return true;
        }

        // TENANT nunca vê SYSTEM
        if ($targetUser->type === 'SYSTEM') {
            return false;
        }

        // TENANT só vê do próprio tenant
        return $authUser->tenant_id === $targetUser->tenant_id;
    }

    /**
     * Criar usuário
     */
    public function create(User $authUser): bool
    {
        return $this->isSystem($authUser) || $this->isTenant($authUser);
    }

    /**
     * Atualizar usuário
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // SYSTEM pode tudo
        if ($this->isSystem($authUser)) {
            return true;
        }

        // TENANT nunca altera SYSTEM
        if ($targetUser->type === 'SYSTEM') {
            return false;
        }

        return $authUser->tenant_id === $targetUser->tenant_id;
    }

    /**
     * Excluir usuário
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        return $this->update($authUser, $targetUser);
    }
}
