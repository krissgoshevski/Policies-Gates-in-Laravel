<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $search = $request->input('search');
        $results = Task::where('name', 'like', "%$search%")->get();

        return view('tasks.index', ['results' => $results]);
    }


public function ajaxSearch(Request $request)
{
    $search = $request->input('search');
    $tasks = Task::where('name', 'like', "%$search%")
        ->select('id', 'name', 'created_at', 'due_date')
        ->get();

    return response()->json($tasks);
}

}
