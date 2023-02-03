<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = new Task;
        $task->name = $request->name;
        $task->done = $request->done;
        $task->due_date = $request->due_date;
        $task->save();
        return response()->json($task, 201);
    }
}
