<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * Get all users with their associated tasks.
     *
     * @return Collection
     */
    public function getUsersWithTasks(): Collection;

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Retrieves the user with given id with tasks and categories.
     *
     * @param string $userId
     * @return User
     */
    public function findWithTasksAndCategory(string $userId): User;
}

