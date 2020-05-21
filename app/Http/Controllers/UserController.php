<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Requests\People;
use App\Http\Requests\SignIn;
use App\Http\Requests\SignUp;
use App\User;
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

            return response()->json([
                'success' => true,
                'user id' => $user->id
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 200);

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
        if ($user = User::where(['email' => $request->email])->with('people')->first() and ($request->password == $user->password)) {
            if ($user->active == 1) {
                $token = $user->generateToken();
                return response()->json([
                    'success' => true,
                    'role' => $user->role,
                    $user,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'active' => $user->active,
                    'message' => 'Вам нужно подтвердить почту',
                ], 200);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Пользователя с такими данными не существует',
        ], 200);
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
        $user = User::with('people')->get();
        return response()->json([
            'success' => true,
            $user
        ], 200);
    }

    /**
     * Вывод всех тренеров
     * @return object
     */
    public function trainer()
    {
        $user = User::where(['role' => 'trainer'])->with('people')->get();
        return response()->json([
            'success' => true,
            $user
        ], 200);
    }

    /**
     * Вывод всех подопечных
     * @return object
     */
    public function sportsmen()
    {
        $user = User::where(['role' => 'user'])->with('people')->get();
        return response()->json([
            'success' => true,
            $user
        ], 200);
    }

    /**
     * Отзывы конкретного пользователя
     * @return object
     */
    public function show()
    {
//        $feedback = User::where(['id' => Auth::id()])->with('feedback')->get();
        $feedback = Feedback::where(['user_id' => Auth::id()])->get();
        return response()->json([
            'success' => true,
            $feedback
        ], 200);
    }

    /**
     * Удаление пользователя
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Пользователь удалён'
        ], 200);
    }

    /**
     * Дополнительная информация в аккаунте
     * @param People $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(People $request)
    {
            $fileName = md5(time() + rand(0, 50)) . "." . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->move(public_path("/image"), $fileName);
            $info = new \App\People();
            $info->first_name = $request->first_name;
            $info->second_name = $request->second_name;
            $info->age = $request->age;
            $info->height = $request->height;
            $info->weight = $request->weight;
            $info->gender = $request->gender;
            $info->activity = $request->activity;
            $info->user_id = Auth::id();
            $info->photo = url('/image/' . $fileName);
            $info->description = $request->description;
            $info->experience = $request->experience;
            $info->target = $request->target;
            $info->info_self = $request->info_self;
            $info->save();
            return response()->json([
                'success' => true,
            ], 201);
    }
}

