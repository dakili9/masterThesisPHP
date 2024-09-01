<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
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
            $scopeMethod = 'By' . ucfirst($filter);

            if (method_exists(Task::class, 'scope' . $scopeMethod)) {
                $query = $query->{$scopeMethod}($value);
            }
        }

        return $query->get();
    }
}

