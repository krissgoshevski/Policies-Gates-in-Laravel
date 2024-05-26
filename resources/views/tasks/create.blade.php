@extends('layouts.default-auth-nav')

@section('title', 'Create Page')

@section('content')
    <h1 class="create-page-heading">Create New Task</h1>

    <form class="create-page-form" action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <label class="create-page-label" for="name">Task name:</label>
        <input class="create-page-input" type="text" id="name" name="name" required> 

        <label class="create-page-label" for="description">Description:</label>
        <input class="create-page-input" type="text" id="description" name="description" required> 

        <label class="create-page-label" for="due_date">Due Date:</label>
        <input class="create-page-date" type="date" id="due_date" name="due_date" required> 

        <button class="create-page-button" type="submit">Create Task</button>
    </form>
@endsection
