<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            $validator->errors()
        ], 200));
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute не может быть пустым',
            'email.regex' => 'Такой электронной почты не существует',
            'email.unique' => 'Пользователь с таким E-mail уже существует.',
            'min' => 'Поле :attribute должно содержать минимум :min символов',
            'max' => 'Поле :attribute должно содержать минимум :max символов',
            'confirmed' => 'Пароли должны совпадать',
            'alpha_num' => 'Вы ввели запрещённые символы',
        ];
    }
}
