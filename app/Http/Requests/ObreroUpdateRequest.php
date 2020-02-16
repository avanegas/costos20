<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObreroUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grupo_obrero_id'   => 'required',
            'name'              => 'required',
            'jornalhora'        => 'required|numeric',
            'factor'            => 'required|numeric',
        ];
    }
}
