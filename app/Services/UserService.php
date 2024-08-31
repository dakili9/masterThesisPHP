<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{
    private readonly UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieves all the model instances.
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
     * Validates the array containing attributes for creating a user.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    private function validateCreateData(array $data): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'admin' => ['boolean']
        ];

        $validatedData = Validator::make($data, $rules)->validate();

        return array_diff_key($data, $validatedData);
    }

    /**
     * Validates the array containing attributes for updating a user.
     *
     * @param string $uuid
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    private function validateUpdateData(string $uuid, array $data): array
    {
        $rules = [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'unique:users,email,'.$uuid.',id'],
            'password' => ['nullable', 'min:8'],
            'admin' => ['nullable', 'boolean']
        ];

        $validatedData = Validator::make($data, $rules)->validate();

        return array_diff_key($data, $validatedData);
    }
}
