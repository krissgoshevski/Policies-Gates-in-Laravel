<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\TaskRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        
   

        $search = $request->input('search');

        // Fetch tasks based on search query and role permissions
        if ($search) {
            $tasks = Task::where('name', 'like', "%$search%")
                ->select('id', 'name', 'created_at', 'due_date')
                ->get();
        } else {
            if (Gate::allows('viewAny', Task::class)) {
                $tasks = Task::select('id', 'name', 'created_at', 'due_date')->get();
            } else {
                $tasks = Task::where('user_id', Auth::id())
                    ->select('id', 'name', 'created_at', 'due_date')
                    ->get();
            }
        }

        return view('tasks.index', compact('tasks', 'search'));
    }


    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $tasks = Task::query();

    //     if ($search) {
    //         $tasks->where('name', 'like', "%$search%");
    //     }

    //     if (Gate::allows('viewAny', Task::class)) {
    //         $tasks = $tasks->select('id', 'name', 'created_at', 'due_date')->get();
    //     } else {
    //         $tasks = $tasks->where('user_id', Auth::id())
    //             ->select('id', 'name', 'created_at', 'due_date')
    //             ->get();
    //     }

    //     return view('tasks.index', compact('tasks', 'search'));
    // }

    public function create()
    {
        $this->authorize('create', Task::class);
        return view('tasks.create');
    }

    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        Task::create($validatedData);

        return redirect()->route('tasks.index')->with('success', 'New Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }


   


    public function edit($id)
{
    $task = Task::findOrFail($id);
    $this->authorize('update', $task);
    return view('tasks.edit', compact('task'));
}

public function update(TaskRequest $request, $id)
{
    $task = Task::findOrFail($id);
    $this->authorize('update', $task);

    $validatedData = $request->validated();
    $task->update($validatedData);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}


    // public function update(TaskRequest $request, Task $task)
    // {
    //     $this->authorize('update', $task);

    //     $validatedData = $request->validated();
    //     $task->update($validatedData);

    //     return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    // }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
