<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\ViewModels\TaskViewModel;
use App\Http\ViewModels\UserTasksViewModel;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UsersController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }
    private readonly UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();

        return response()->json($users);
    }

    public function show(string $uuid): JsonResponse
    {
        $user = $this->userService->getById($uuid);

        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        Gate::authorize('create', User::class);

        $reqData = $request->only([
            'name',
            'email',
            'password'
        ]);
        $user = $this->userService->create($reqData);

        return response()->json($user, 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, string $uuid): JsonResponse
    {
        $user = $this->userService->getById($uuid);
        Gate::authorize('update', $user);

        $reqData = $request->only([
            'name',
            'password'
        ]);
        $updatedUser = $this->userService->update($uuid, $reqData);

        return response()->json($updatedUser);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        $user = $this->userService->getById($uuid);
        Gate::authorize('destroy', $user);

        $deleted = $this->userService->delete($uuid);

        return response()->json(['success' => $deleted]);
    }

    /**
     * Sets user to be an admin.
     *
     * @param string $userId
     * @return JsonResponse
     */
    public function setAdmin(string $userId): JsonResponse
    {
        Gate::authorize('updateSensitive', User::class);

        $updatedUser = $this->userService->update($userId, ['admin' => true]);

        return response()->json($updatedUser);
    }

    /**
     * Changes users email.
     *
     * @param ChangeEmailRequest $request
     * @param string $userId
     * @return JsonResponse
     */
    public function changeEmail(ChangeEmailRequest $request, string $userId): JsonResponse
    {
        Gate::authorize('updateSensitive', User::class);

        $updatedUser = $this->userService->update($userId, ['email' => $request->input('email')]);

        return response()->json($updatedUser);
    }

//    /**
//     * Display the user's tasks.
//     *
//     * @param string $userId
//     * @return View
//     */
//    public function showUserTasks(string $userId): View
//    {
//        $user = User::with(['tasks.category:id,name'])->findOrFail($userId);
//
//        return view('userTasks', ['user' => $user]);
//    }

    /**
     * Display the user's tasks.
     *
     * @param string $userId
     * @return View
     */
    public function showUserTasks(string $userId): View
    {
        $viewModel = $this->getUserTasksViewModel($userId);

        return view('userTasks', ['view' => $viewModel]);
    }

    /**
     * Generates a userTasks view model for a user with a certain id.
     *
     * @param $userId
     * @return UserTasksViewModel
     */
    private function getUserTasksViewModel($userId): UserTasksViewModel
    {
        $userData = $this->userService->getUserWithTasks($userId);

        $taskViewModels = $userData['tasks']->map(function ($task) {
            return new TaskViewModel(
                $task->name,
                $task->description,
                $task->status,
                $task->due_date,
                $task->category->name
            );
        });

        return new UserTasksViewModel($userData['name'], $taskViewModels);
    }
}
