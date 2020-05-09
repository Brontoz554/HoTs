<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class People extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:2|max:40|regex:/[А-яЁё A-z0-9,]/',
            'second_name' => 'required|min:2|max:40|regex:/[А-яЁё A-z0-9,]/',
            'height' => 'required|min:2|max:3|regex:/[0-9]/',
            'weight' => 'required|min:2|max:3|regex:/[0-9]/',
            'activity' => 'required|min:2|max:50|regex:/[А-яЁё A-z0-9,]/',
            'gender' => 'required|min:2|max:20',
            'age' => 'required|min:1|max:3|regex:/[0-9]/',
            'photo' => 'required|mimes:jpeg,bmp,png'
        ];
    }
}
