<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * Filter tasks based on the provided criteria.
     *
     * @param array $filters
     * @return Collection
     */
    public function filter(array $filters): Collection;
}

