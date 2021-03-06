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
            'email.required' => 'Поле Емайл не может быть пустым',
            'role.required' => 'Вы должны выбрать кем вы будете, тренером или подопечным',
            'photo.required' => 'Вам нужно загрузить вашу аватарку',
            'photo.max' => 'Максимальный размер изображения 10МБ',
            'comment.required' => 'Поле Ваш отзыв не может быть пустым',
            'password.required' => 'Поле пароль не может быть пустым',
            'password_confirmation.required' => 'Поле повторите пароль не может быть пустым',
            'first_name.required' => 'Поле имя не может быть пустым',
            'second_name.required' => 'Поле фамилия не может быть пустым',
            'height.required' => 'Поле рост не может быть пустым',
            'weight.required' => 'Поле вес не может быть пустым',
            'activity.required' => 'Поле активность не может быть пустым',
            'gender.required' => 'Поле пол не может быть пустым',
            'age.required' => 'Поле возраст не может быть пустым',
            'email.regex' => 'Вы используете запрещённые символы',
            'description.regex' => 'Вы используете запрещённые символы',
            'experience.regex' => 'Вы используете запрещённые символы',
            'target.regex' => 'Вы используете запрещённые символы',
            'info_self' => 'Вы используете запрещённые символы',
            'role.regex' => 'Вы используете запрещённые символы',
            'email.unique' => 'Пользователь с таким E-mail уже существует.',
            'min' => 'Поле может содержать минимум :min символов',
            'max' => 'Поле может содержать максимум :max символов',
            'confirmed' => 'Пароли должны совпадать',
            'alpha_num' => 'Вы ввели запрещённые символы',
        ];
    }
}
