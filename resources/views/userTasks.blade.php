@php
    /** @var $view App\Http\ViewModels\UserTasksViewModel */
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Tasks</title>
</head>
<body>
<h1>Hi, {{ $view->name }}!</h1>
<h2>Your Tasks</h2>

@if($view->tasks->isEmpty())
    <p>You have no tasks.</p>
@else
    <ul>
        @foreach($view->tasks as $task)
            <li>
                <strong>{{ $task->name }}</strong> - {{ $task->description }}<br>
                Status: {{ $task->status }}<br>
                Due Date: {{ $task->dueDate->format('Y-m-d') }}<br>
                Category: {{ $task->categoryName }}<br>
            </li>
        @endforeach
    </ul>
@endif
</body>
</html>
