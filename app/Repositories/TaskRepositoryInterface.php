<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

interface TaskRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * Get all tasks assigned to a specific user.
     *
     * @param string $userId
     * @return Collection
     */
    public function getTasksByUser(string $userId): Collection;

    /**
     * Get all tasks that belong to a specific category.
     *
     * @param string $categoryId
     * @return Collection
     */
    public function getTasksByCategory(string $categoryId): Collection;

    /**
     * Get all tasks with a specific status.
     *
     * @param string $status
     * @return Collection
     */
    public function getTasksByStatus(string $status): Collection;

    /**
     * Get all tasks due before a specific date.
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getTasksDueBefore(Carbon $date): Collection;

    /**
     * Filter tasks based on the provided criteria.
     *
     * @param array $filters
     * @return Collection
     */
    public function filter(array $filters): Collection;
}

