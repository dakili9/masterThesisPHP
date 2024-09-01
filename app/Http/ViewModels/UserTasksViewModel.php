<?php

namespace App\Http\ViewModels;

use Illuminate\Support\Collection;

class UserTasksViewModel
{
    public string $name;

    /** @var $tasks Collection<int, TaskViewModel> */
    public Collection $tasks;

    public function __construct(
        string $name,
        Collection $task
    ){
        $this->name = $name;
        $this->tasks = $task;
    }
}
