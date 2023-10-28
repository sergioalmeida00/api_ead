<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
        if ($this->isMethod('POS')) {
            return [
                'email' => ['required', 'email', 'unique:users'],
                'name' => ['required', 'min:3', 'string'],
                'password' => ['required', 'min:6', 'max:12']
            ];
        } else {
            return [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore(auth()->user()->id),
                ],
                'name' => ['required', 'min:3', 'string'],
                'password' => ['min:6', 'max:12']
            ];
        }
    }
}
