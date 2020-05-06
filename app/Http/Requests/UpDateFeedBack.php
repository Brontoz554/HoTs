<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpDateFeedBack extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|max:200|min:20|regex:/[А-яЁё A-z0-9,]/',
            'id' => 'required|alpha_num',
        ];
    }
}
