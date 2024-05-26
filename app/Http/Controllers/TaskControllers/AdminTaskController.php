<?php

namespace App\Http\Controllers\TaskControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class AdminTaskController extends Controller
{
    // //

    // public function index()
    // {
    //     $tasks = Task::with('user')->orderBy('due_date')->get();

    //     return view('admin.tasks.index', compact('tasks'));
    // }


     //
     public function index()
     {
         // $tasks = auth()->user()->tasks();
         $tasks = Task::with('user')->orderBy('due_date')->get();
 
         return view('admin.tasks.index', compact('tasks'));
     }
 
     public function create()
     {
         $this->authorize('create', Task::class); // avtentikacija so TaskPolicy
 
         return view('admin.tasks.create');
     }
 
     public function store(Request $request)
     {
         $this->authorize('admin.create', Task::class);
 
         Task::create($request->only('due_date'));
 
         return redirect()->route('tasks.index');
     }
 
     public function edit(Task $task) {
         $this->authorize('update', $task);
 
         return view('admin.tasks.edit', compact('task'));
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
 
         return redirect()->route('tasks.index');
     }
 

   
}
