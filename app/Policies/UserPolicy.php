<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
    public function view(User $user, User $model): bool
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
            Response::deny('You do not have permission to create user.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        return $user->admin || $user->id === $model->id ?
            Response::allow() :
            Response::deny('You do not have permission to update user.');
    }

    public function updateSensitive(User $user, User $model): Response
    {
        return $user->admin  ?
            Response::allow() :
            Response::deny('You do not have permission to create user.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): Response
    {
        return $user->admin ?
            Response::allow() :
            Response::deny('You do not have permission to create user.');
    }
}
