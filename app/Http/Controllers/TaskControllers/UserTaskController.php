<?php

namespace App\Http\Controllers\TaskControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class UserTaskController extends Controller
{
    //
    public function index()
    {
        // $tasks = auth()->user()->tasks();
        $tasks = Task::with('user')->orderBy('due_date')->get();

        return view('user.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $this->authorize('create', Task::class); // avtentikacija so TaskPolicy

        return view('user.tasks.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        Task::create($request->only('due_date'));

        return redirect()->route('user.tasks.index');
    }

    public function edit(Task $task) {
        $this->authorize('update', $task);

        return view('user.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->only('due_date'));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('user.tasks.index');
    }





}
