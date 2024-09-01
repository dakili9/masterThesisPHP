<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseServiceInterface;

interface UserServiceInterface extends BaseServiceInterface
{
    /**
     * Retrieves the user with given id with category and tasks.
     *
     * @param string $userId
     * @return array
     */
    public function getUserWithTasks(string $userId): array;
}
