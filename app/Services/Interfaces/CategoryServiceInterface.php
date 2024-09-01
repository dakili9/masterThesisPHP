<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface extends BaseServiceInterface
{
    /**
     * Retrieves categories with task count for each.
     *
     * @return Collection
    */
    public function getCategoriesWithTaskCount(): Collection;
}
