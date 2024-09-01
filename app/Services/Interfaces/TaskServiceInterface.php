<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface extends BaseServiceInterface
{
    /**
     * Filter tasks according to given filters.
     *
     * @param $data
     * @return Collection
     */
    public function filter($data): Collection;
}
