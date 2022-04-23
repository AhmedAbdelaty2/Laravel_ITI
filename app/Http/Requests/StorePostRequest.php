<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
        $id = null;
        if(isset(explode('/',$this->getPathInfo())[2])){
            $id = explode('/',$this->getPathInfo())[2];
        }

        return [
            'title' => ['required','min:3', Rule::unique('App\Models\Post')->ignore($id)],
            'description' => ['required', 'min:5'],
            'post_creator' => ['exists:App\Models\User,id'],
        ];
    }
}
