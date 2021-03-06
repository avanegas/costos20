<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
        	'user_id'		=> 'required|integer',
            'category_id'   => 'required|integer',
            'name'          => 'required',
            'slug'          => 'required|unique:posts,slug,' . $this->post,
            'excerpt'       => 'required',
            'body'          => 'required',
            'status'        => 'required|in:DRAFT,PUBLISHED',
            'tags'          => 'required|array',
        ];

        if ($this->get('image->url->File->name'))
        {
           $rules = array_merge($rules, ['image->url->File->name' => 'mimes:jpg,jpeg,png']);
        }

        return $rules;
    }
}
