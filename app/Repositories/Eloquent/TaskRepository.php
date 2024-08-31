<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    /*todo individual getters by a certain property*/

    /**
     * Get all tasks assigned to a specific user.
     *
     * @param string $userId
     * @return Collection
     */
    public function getTasksByUser(string $userId): Collection
    {
        return Task::byUser($userId)->get();
    }

    /**
     * Get all tasks that belong to a specific category.
     *
     * @param string $categoryId
     * @return Collection
     */
    public function getTasksByCategory(string $categoryId): Collection
    {
        return Task::byCategory($categoryId)->get();
    }

    /**
     * Get all tasks with a specific status.
     *
     * @param string $status
     * @return Collection
     */
    public function getTasksByStatus(string $status): Collection
    {
        return Task::byStatus($status)->get();
    }

    /**
     * Get all tasks due before a specific date.
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getTasksDueBefore(Carbon $date): Collection
    {
        return Task::dueBefore('due_date')->get();
    }

    /**
     * Filter tasks based on the provided criteria.
     *
     * @param array $filters
     * @return Collection
     */
    public function filter(array $filters): Collection
    {
        $query = Task::query();

        foreach ($filters as $filter => $value) {
            if (method_exists(Task::class, 'scope' . ucfirst($filter))) {
                $query = $query->{'scope' . ucfirst($filter)}($value);
            }
        }

        return $query->get();
    }
}

