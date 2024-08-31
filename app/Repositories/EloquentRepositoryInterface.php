<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Get all instances of the model.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find an instance of the model by its primary key.
     *
     * @param string $id
     * @return Model|null
     */
    public function find(string $id): ?Model;

    /**
     * Create a new instance of the model with the given attributes.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * Update an instance of the model by its primary key with the given attributes.
     *
     * @param string $id
     * @param array $attributes
     * @return Model|null
     */
    public function update(string $id, array $attributes): ?Model;

    /**
     * Delete an instance of the model by its primary key.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
