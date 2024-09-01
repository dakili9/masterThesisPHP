<?php

namespace App\Http\ViewModels;

use App\Enums\TaskStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;


class TaskViewModel
{
    public string $name;

    public string $description;

    public string $status;

    public Carbon $dueDate;

    public string $categoryName;

    public function __construct(
        string $name,
        string $description,
        TaskStatus $status,
        Carbon $dueDate,
        string $categoryName
    )
    {
        $this->name = trim($name);
        $this->description = trim($description);
        $this->status = $status->value;
        $this->dueDate = $dueDate;
        $this->categoryName = trim($categoryName);
    }

}
