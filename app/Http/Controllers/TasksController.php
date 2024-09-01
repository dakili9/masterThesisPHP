<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\JsonResponse;

class TasksController extends Controller
{
    private readonly TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAll();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $reqData = $request->only([
            'name',
            'description',
            'status',
            'user_id',
            'category_id',
            'due_date',
        ]);
        $task = $this->taskService->create($reqData);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $task = $this->taskService->getById($uuid);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, string $uuid): JsonResponse
    {
        $reqData = $request->only([
            'name',
            'description',
            'status',
            'user_id',
            'category_id',
            'due_date',
        ]);
        $updatedTask = $this->taskService->update($uuid, $reqData);

        return response()->json($updatedTask);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        $deleted = $this->taskService->delete($uuid);

        return response()->json(['success' => $deleted]);
    }
}
