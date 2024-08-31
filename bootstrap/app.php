<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')&& ($e->getPrevious() instanceof  ModelNotFoundException)) {
                $message = match ($e->getPrevious()->getModel()) {
                    'App\Models\User' => 'User not found.',
                    'App\Models\Task' => 'Task not found.',
                    'App\Models\Category' => 'Category not found.',
                };
                return response()->json([
                    'message' => $message
                ], 404);
            }
        });
    })->create();
