<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class TaskService implements TaskServiceInterface
{
    private readonly TaskRepositoryInterface $taskRepository;

    private readonly UserRepositoryInterface $userRepository;

    private readonly CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        UserRepositoryInterface $userRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**s
     * Retrieves all the model instances.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->taskRepository->all();
    }

    /**
     * Retrieves the model by id.
     *
     * @param string $uuid
     * @return Model
     */
    public function getById(string $uuid): Model
    {
        return $this->taskRepository->find($uuid);
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

        $this->checkIfUserAndCategoryExist($data);

        return $this->taskRepository->create($data);
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
        $this->checkIfUserAndCategoryExist($data);

        return $this->taskRepository->update($uuid, $data);
    }

    /**
     * Removes model with given id.
     *
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool
    {
        return $this->taskRepository->delete($uuid);
    }

    /**
     * Checks if user and category ids exist.
     *
     * @param array $data
     * @return void
     */
    private function checkIfUserAndCategoryExist(array $data): void
    {
        if (!$this->userRepository->exists($data['user_id'])) {
            throw new ModelNotFoundException("User not found");
        }

        if (isset($data['category_id']) && !$this->categoryRepository->exists($data['category_id'])) {
            throw new ModelNotFoundException("Category not found");
        }
    }

    /**
     * Filter tasks according to given filters.
     *
     * @param $data
     * @return Collection
     */
    public function filter($data): Collection
    {
        return $this->taskRepository->filter($data);
    }
}
