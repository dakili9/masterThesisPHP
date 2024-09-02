<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->admin ?
            Response::allow() :
            Response::deny('You do not have permission to create tasks.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        //var_dump($user->id, $task->user_id);
        return $user->admin || $user->id === $task->user_id ?
            Response::allow() :
            Response::deny('You do not have permission to update this task.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(User $user): Response
    {
        return $user->admin ?
            Response::allow() :
            Response::deny('You do not have permission to delete tasks.');
    }
}
