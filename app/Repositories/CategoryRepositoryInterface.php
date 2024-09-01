<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * Find a category by its name.
     *
     * @param string $name
     * @return Category|null
     */
    public function findByName(string $name): ?Category;

    /**
     * Get all categories along with the number of tasks in each category.
     *
     * @return Collection
     */
    public function getCategoriesWithTaskCount(): Collection;
}


