<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests\SignIn;
use App\Http\Requests\SignUp;
use App\User;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    /**
     * Регистрация пользователя и отправка сообщения на почту
     * @param SignUp $request
     * @return object
     */
    public function store(SignUp $request)
    {
        $user = User::create($request->all());
        if ($user) {
            $data = array('name' => $user->email, "body" => "Test mail");
            Mail::send('mail', $data, function ($message) use ($user) {
                $message->to($user->email)->subject('Добро пожаловать в нашу дружную семью');
                $message->from('tifilum2020@gmail.com');
            });
        }
        return response()->json([
            'success' => true,
            'user id' => $user->id
        ], 201);
    }

    /**
     * Подтверждение почты
     * @param Request $request
     * @return object
     */
    public function confirm(Request $request)
    {
        $user = User::where(['email' => $request->yes])->first();
        if ($user->active == 0) {
            $user->active = 1;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Ваш аккаунт успешно активирован',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Ваш аккаунт уже был активирован',
        ]);
    }

    /**
     * Авторизация пользователя, если его почта подтверждена
     * @param SignIn $request
     * @return object
     */
    public function login(SignIn $request)
    {
        if ($user = User::where(['email' => $request->email])->first() and ($request->password == $user->password)) {
            if ($user->active == 1) {
                $token = $user->generateToken();
                return response()->json([
                    'success' => true,
                    $user,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Вам нужно подтвердить почту',
                ], 200);
            }
        }
    }

    /**
     * Выход из системы
     * @return object
     */
    public function logout()
    {
        $user = User::where(['id' => Auth::user()->id])->first();
        $user->api_token = null;
        $user->save();
        return response()->json([
            'success' => true,
        ], 200);
    }

    /**
     * Вывод всех пользователей
     * @return object
     */
    public function index()
    {
//        $user = User::with('feedback')->get();
        $user = User::all();
        return response()->json([
            'success' => true,
            $user
        ], 200);
    }

    public function show()
    {
//        $feedback = User::where(['id' => Auth::id()])->with('feedback')->get();
        $feedback = Feedback::where(['user_id' => Auth::id()])->get();
        return response()->json([
            'success' => true,
            $feedback
        ], 200);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Пользователь удалён'
        ], 200);
    }
}

