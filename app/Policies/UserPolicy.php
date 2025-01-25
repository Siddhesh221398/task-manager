<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, User $model): bool
    {
        return $user->role === 'admin'; 
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function update(User $user, User $model): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'manager') {
            // Managers cannot update admins
            return $model->role !== 'admin';
        }

        return false;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, User $model): bool
    {
        
    }

    public function forceDelete(User $user, User $model): bool
    {
        
    }
}
