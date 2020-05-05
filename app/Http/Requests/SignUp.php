<?php

namespace App\Http\Requests;


class SignUp extends ApiRequest
{
    public function rules()
    {
        return [
            'email' => 'required|unique:user|min:10|max:40|regex:/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/',
            'password' => 'required|alpha_num|confirmed|min:6|max:20',
            'password_confirmation' => 'required|alpha_num|min:6|max:20',
            'role' => 'required|alpha_dash',
        ];
    }
}

