<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryService implements CategoryServiceInterface
{
    private readonly CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Retrieves all the model instances.
     */
    public function getAll(): Collection
    {
        return $this->categoryRepository->all();
    }

    /**
     * Retrieves the model by id.
     *
     * @param string $uuid
     * @return Model
     */
    public function getById(string $uuid): Model
    {
        return $this->categoryRepository->find($uuid);
    }

    /**
     * Creates model from given attributes.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $data['id'] = (string)Str::uuid();

        return $this->categoryRepository->create($data);
    }

    /**
     * Updates model with the given id.
     *
     * @param string $uuid
     * @param array $data
     * @return Model
     */
    public function update(string $uuid, array $data): Model
    {
        return $this->categoryRepository->update($uuid, $data);
    }

    /**
     * Removes model with given id.
     *
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool
    {
        return $this->categoryRepository->delete($uuid);
    }

    /**
     * Retrieves categories with task count for each.
     *
     * @return Collection
     */
    public function getCategoriesWithTaskCount(): Collection
    {
        return $this->categoryRepository->getCategoriesWithTaskCount();
    }

}
