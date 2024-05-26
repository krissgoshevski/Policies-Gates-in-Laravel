
@extends('layouts.default')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Tasks</title>
</head>
<body>
    <h1>Welcome, User!</h1>
    <p>This is the page for user tasks.</p>

    <!-- Allow users to create a task if authorized -->
    @can('create', App\Models\Task::class)
    <a href="{{ route('user.tasks.create') }}">Create Task</a>
    @endcan

    <ul>
        @foreach ($tasks as $task)
        <li>{{ $task->name }}</li>

        <!-- Allow users to edit a task if authorized -->
        @can('update', $task)
        <a href="{{ route('user.tasks.edit', $task) }}">Edit</a>
        @endcan

        <!-- Allow users to delete a task if authorized -->
        @can('delete', $task)
        <form action="{{ route('user.tasks.destroy', $task) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
        @endcan

        @endforeach
    </ul>
</body>
</html>
