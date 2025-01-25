<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function view(User $user, Task $task): bool
    {
        return $user->role === 'admin' || 
               $user->role === 'manager' || 
               $user->id === $task->assigned_to;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function update(User $user, Task $task): bool
    {
        return $user->role === 'admin' || 
               $user->role === 'manager' || 
               $user->id === $task->assigned_to; 
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Task $task): bool
    {
        
    }

    public function forceDelete(User $user, Task $task): bool
    {
        
    }

    public function export(User $user)
    {
        return $user->role === 'admin'; // Only allow admins
    }
}
