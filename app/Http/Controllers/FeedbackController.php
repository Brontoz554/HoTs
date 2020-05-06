<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpDateFeedBack;
use App\User;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(PostRequest $request)
    {
        $feedback = new Feedback();
        $feedback->user_id = Auth::id();
        $feedback->comment = $request->comment;
        if ($feedback->save()) {
            return response()->json([
                'success' => true,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }

    public function index()
    {
        $feedback = User::with('feedback')->get();
        $NotNullFeedback = [];
        foreach ($feedback as $item) {
            if (count($item->feedback) != 0) {
                array_push($NotNullFeedback, $item);
            }
        }
        return response()->json([
            'success' => true,
            $NotNullFeedback,
        ], 200);
    }

    public function update(UpDateFeedBack $request)
    {
        $update = Feedback::where(['id' => $request->id])->first();
        if ($update->user_id == Auth::id()) {
            $update->comment = $request->comment;
            $update->save();
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function delete(Feedback $feedback)
    {
        if ($feedback->user_id == Auth::id()) {
            $feedback->delete();
            return response()->json([
                'success' => true,
            ], 200);
        }
    }
}

