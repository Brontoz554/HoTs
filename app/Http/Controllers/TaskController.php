<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'list_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'IncorrectNameException',
            ])->setStatusCode(404);
        }

        $task = Task::create($request->all());
        return response()->json([
            'message' => 'success',
            'id' => $task->id,
            'name' => $task->name,
        ], 201);
    }
}

