@extends('layouts.default')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tasks</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <p>This is the page for admin tasks.</p>

    <!-- Allow admins to create a task if authorized -->
    @can('create', App\Models\Task::class)
    <a href="{{ route('admin.tasks.create') }}">Create Task</a>
    @endcan

    <ul>
        @foreach ($tasks as $task)
        <li>{{ $task->name }}</li>

        <!-- Allow admins to edit a task if authorized -->
        @can('update', $task)
        <a href="{{ route('admin.tasks.edit', $task) }}">Edit</a>
        @endcan

        <!-- Allow admins to delete a task if authorized -->
        @can('delete', $task)
        <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
        @endcan

        @endforeach
    </ul>
</body>
</html>
