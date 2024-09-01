<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all users with their associated tasks.
     *
     * @return Collection
     */
    public function getUsersWithTasks(): Collection
    {
        return $this->model->with('tasks')->get();
    }

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Retrieves the user with given id with tasks and categories.
     *
     * @param string $userId
     * @return User
     */
    public function findWithTasksAndCategory(string $userId): User
    {
        return $this->model::with(['tasks.category:id,name'])->findOrFail($userId);
    }
}

