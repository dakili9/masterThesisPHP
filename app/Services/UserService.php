<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    private readonly UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieves all the model instances.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Retrieves the model by id.
     *
     * @param string $uuid
     * @return Model
     */
    public function getById(string $uuid): Model
    {
        return $this->userRepository->find($uuid);
    }

    /**
     * Creates model from given attributes.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $data['id'] = (string) Str::uuid();

        return $this->userRepository->create($data);
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
        return $this->userRepository->update($uuid, $data);
    }

    /**
     * Removes model with given id.
     *
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool
    {
        return $this->userRepository->delete($uuid);
    }

    /**
     * Retrieves the user with given id with category and tasks.
     *
     * @param string $userId
     * @return array
     */
    public function getUserWithTasks(string $userId): array
    {
        $user = $this->userRepository->findWithTasksAndCategory($userId);

        return [
            'name' => $user->name,
            'tasks' => $user->tasks
        ];
    }
}
