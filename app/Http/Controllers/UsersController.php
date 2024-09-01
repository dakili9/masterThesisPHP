<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
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
        $updatedUser = $this->userService->update($userId, ['email' => $request->input('email')]);
        return response()->json($updatedUser);
    }
}
