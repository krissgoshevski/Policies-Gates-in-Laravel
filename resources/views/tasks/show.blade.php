@extends('layouts.default-auth-nav')

@section('title', 'Show Page')

@section('content')
@can('view', $task) {{-- Ensure user can view the task --}}
    <div class="show-page-content">
        {{-- <h1 class="show-page-heading">Show page</h1> --}}
        <h1 class="show-page-details"><b> Details of the Task: </b> {{ $task->name }}</h1>
        <p class="show-page-details"> <b> Description: </b> {{ $task->description }}</p>
        <p class="show-page-details"> <b> Created at: </b> {{ $task->created_at }}</p>
        <p class="show-page-details"> <b> Updated at: </b> {{ $task->updated_at }}</p>
        <p class="show-page-details"> <b> Due Date: </b> {{ $task->due_date }}</p>
    </div>
@endcan
@endsection
