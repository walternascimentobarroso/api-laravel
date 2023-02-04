<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(10);
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'done' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->done = $request->done;
        $task->due_date = $request->due_date;
        $task->save();
        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::where('id', $id)->first();
        if (!$task) {
            return response()->json('Task not found', 404);
        }
        return response()->json($task);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $task = Task::where('id', $id)->first();
        if (!$task) {
            return response()->json('Task not found', 404);
        }
        $task->update($request->all());
        return response()->json($task, 201);
    }

    public function destroy($id)
    {
        $task = Task::where('id', $id)->first();
        if (!$task) {
            return response()->json('Task not found', 404);
        }
        $task->delete();
        return response()->json('Task deleted!');
    }
}
