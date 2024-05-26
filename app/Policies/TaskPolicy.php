<?php
namespace App\Policies;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role_id == Role::IS_ADMIN || $user->role_id == Role::IS_USER;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Task $task): bool
    {
        // // Admin can view all tasks, while regular users can only view tasks they created
        
       return ($user->role_id == Role::IS_ADMIN) || ($task->user_id === $user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // Admins have full access
        Log::info('User ID: ' . $user->id . ', Role ID: ' . $user->role_id);
        Log::info('Task User ID: ' . $task->user_id);

        return ($user->role_id == Role::IS_ADMIN) || ($task->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return ($user->role_id == Role::IS_ADMIN) || ($task->user_id === $user->id);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    { 
         return $user->role_id == Role::IS_ADMIN || $user->role_id == Role::IS_USER;
    }
}
