@extends('layouts.default-auth-nav')
@section('title', 'Index Page')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if(Auth::check())
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <p>Your role id is: {{ Auth::user()->role_id }}</p>
    <p>Your role is: {{ Auth::user()->role->name }}</p>

    @if(session('verified'))
        <p class="fade-in-out">Your email has been successfully verified.</p>
    @endif
@endif

<h1>All Tasks</h1>
<form action="{{ route('tasks.index') }}" method="GET" class="search-form">
    <input type="text" id="search" name="search" placeholder="Search Tasks" value="{{ $search }}">
    <button type="submit">Search by Task name</button>
</form>

@if (isset($tasks) && count($tasks) > 0)
<table>
    <thead>
        <tr>
            <th>#No.</th>
            <th>Task</th>
            <th>Created at</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="task-table-body">
        @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->name }}</td>
            <td>{{ $task->created_at }}</td>
            <td>{{ $task->due_date }}</td>
            <td class="actions">
                @can('view', $task)
                <a href="{{ route('tasks.show', $task) }}" class="action-btn action-show">
                    <i class="fas fa-eye"></i> 
                </a>
                @endcan
                @can('update', $task)
                <a href="{{ route('tasks.edit', $task) }}" class="action-btn action-update">
                    <i class="fas fa-edit"></i>
                </a>
                @endcan
                @can('delete', $task)
                <form class="delete-form inline" action="{{ route('tasks.delete', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn action-delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p class="no-results">No results found.</p>
@endif

<script>
    $(document).ready(function() {
        $('#search').on('input', function() {
            var search = $(this).val();
            $.ajax({
                url: "{{ route('tasks.ajaxSearch') }}",
                type: 'GET',
                data: { search: search },
                success: function(tasks) {
                    var tableBody = $('#task-table-body');
                    tableBody.empty();
                    if (tasks.length > 0) {
                        $.each(tasks, function(index, task) {
                            var canView = task.can_view ? '<a href="/tasks/' + task.id + '" class="action-btn action-show"><i class="fas fa-eye"></i></a>' : '';
                            var canUpdate = task.can_update ? '<a href="/tasks/' + task.id + '/edit" class="action-btn action-update"><i class="fas fa-edit"></i></a>' : '';
                            var canDelete = task.can_delete ? 
                                '<form class="delete-form inline" action="/tasks/' + task.id + '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">' +
                                '@csrf' +
                                '@method("DELETE")' +
                                '<button type="submit" class="action-btn action-delete"><i class="fas fa-trash-alt"></i></button>' +
                                '</form>' : '';

                            var taskRow = `
                                <tr>
                                    <td>${task.id}</td>
                                    <td>${task.name}</td>
                                    <td>${task.created_at}</td>
                                    <td>${task.due_date}</td>
                                    <td class="actions">
                                        ${canView}
                                        ${canUpdate}
                                        ${canDelete}
                                    </td>
                                </tr>
                            `;
                            tableBody.append(taskRow);
                        });
                    } else {
                        tableBody.append('<tr><td colspan="5" class="no-results">No results found.</td></tr>');
                    }
                }
            });
        });
    });
</script>

@endsection
