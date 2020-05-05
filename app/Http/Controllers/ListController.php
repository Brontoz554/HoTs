<?php

namespace App\Http\Controllers;

use App\Listt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    public function index()
    {
        Listt::all();
        return response()->json(Listt::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'IncorrectNameException',
            ])->setStatusCode(404);
        }

        $list = Listt::create($request->all());
        return response()->json([
            'message' => 'success',
            'id' => $list->id,
            'name' => $list->name,
        ], 201);
    }

    public function destroy(Listt $list)
    {
        if ($list->delete()) {
            return response()->noContent(204);
        }
    }

    public function update()
    {

    }
}
