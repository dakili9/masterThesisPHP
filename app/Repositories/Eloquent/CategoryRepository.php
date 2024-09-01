<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Find a category by its name.
     *
     * @param string $name
     * @return Category|null
     */
    public function findByName(string $name): ?Category
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    /**
     * Get all categories along with the number of tasks in each category.
     *
     * @return Collection
     */
    public function getCategoriesWithTaskCount(): Collection
    {
        return  $this->model::withCount('tasks')->get();
    }
}

