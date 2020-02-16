<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $rules = [
            'user_id'   => 'required',
            'bio'       => 'required',
            'phone'     => 'required',
            'avatar_status' => 'required',
            'status'    => 'required',
            'activated' => 'required'
            //'group'      => 'required'
        ];
        if($this->get('url'))
            $rules = array_merge($rules, ['avatar' => 'mimes:jpg,jpeg,png']);
        return $rules;
    }
}
