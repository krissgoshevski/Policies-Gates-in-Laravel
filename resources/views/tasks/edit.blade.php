@extends('layouts.default-auth-nav')

@section('title', 'Edit Task')

@section('content')
    <h1>Edit Task</h1>

    <form class="edit-task-form" action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT') <!-- Use PUT method for updating -->
        
        <label class="edit-task-label" for="name">Task name:</label>
        <input class="edit-task-input" type="text" id="name" name="name" value="{{ $task->name }}" required> 

        <label class="edit-task-label" for="description">Description:</label>
        <input class="edit-task-input" type="text" id="description" name="description" value="{{ $task->description }}" required> 

        <label class="edit-task-label" for="due_date">Due Date:</label>
        <input class="edit-task-input" type="date" id="due_date" name="due_date" value="{{ $task->due_date }}" required> 

        <button class="edit-task-button" type="submit">Update Task</button>
    </form>
@endsection
