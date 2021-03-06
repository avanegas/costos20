<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZonaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id'       => 'required',
            'name'          => 'required',
            'description'   => 'required',
        ];
    }
}
