<?php

namespace App\Repositories\Eloquent;

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements EloquentRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find an instance by ID
     *
     * @param string $id
     * @return Model
     */
    public function find(string $id): Model
    {
        return $this->model->where('id', $id)
            ->firstOrFail();
    }

    /**
     * Create a new instance of the model
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model::create($attributes);
    }

    /**
     * Update an instance by ID
     *
     * @param string $id
     * @param array $attributes
     * @return Model
     */
    public function update(string $id, array $attributes): Model
    {
        $model = $this->find($id);

        $model->update($attributes);

        return $model;
    }

    /**
     * Delete an instance by ID
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $model = $this->find($id);

        return $model->delete();
    }
}

