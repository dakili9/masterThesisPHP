<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Interfaces\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    private readonly CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAll();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        Gate::authorize('crud', Category::class);

        $reqData = $request->only([
            'name',
        ]);

        $category = $this->categoryService->create($reqData);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $category = $this->categoryService->getById($uuid);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, string $uuid): JsonResponse
    {
        Gate::authorize('crud', Category::class);

        $reqData = $request->only([
            'name'
        ]);

        $updatedCategory = $this->categoryService->update($uuid, $reqData);

        return response()->json($updatedCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        Gate::authorize('crud', Category::class);

        $deleted = $this->categoryService->delete($uuid);

        return response()->json(['success' => $deleted]);
    }

    /**
     * Display categories with the task count for each.
     *
     * @return JsonResponse
     */
    public function indexWithTaskCount(): JsonResponse
    {
        $categories = $this->categoryService->getCategoriesWithTaskCount();

        return response()->json($categories);
    }

}
