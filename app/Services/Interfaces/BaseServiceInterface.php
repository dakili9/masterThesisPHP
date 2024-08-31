<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseServiceInterface
{
    /**
     * Retrieves all the model instances.
    */
    public function getAll(): Collection;

    /**
     * Retrieves the model by id.
     *
     * @param string $uuid
     * @return Model
     */
    public function getById(string $uuid): Model;

    /**
     * Creates model from given attributes.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;


    /**
     * Updates model with the given id.
     *
     * @param string $uuid
     * @param array $data
     * @return Model
     */
    public function update(string $uuid, array $data): Model;

    /**
     * Removes model with given id.
     *
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool;
}
