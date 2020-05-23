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
            'photo' => 'required|mimes:jpeg,bmp,png,svg|max:10000',
            'target' => 'max:500|regex:/[А-яЁё A-z0-9,\.\!\?\(\)]/',
            'info_self' => 'max:500|regex:/[А-яЁё A-z0-9,\.\!\?\(\)]/',
            'description' => 'min:5|max:500|regex:/[А-яЁё A-z0-9,\.\!\?\(\)]/',
            'experience' => 'min:5|max:500|regex:/[А-яЁё A-z0-9,\.\!\?\(\)]/'
        ];
    }
}
