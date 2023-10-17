<?php

namespace App\Http\Requests;

use App\Models\Support;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupport extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules(Support $support)
    {
        return [
            'lesson' => ['required', 'exists:lessons,id'],
            'status' => [
                'required',
                Rule::in(array_keys($support->statusOptions))
            ],
            'description' => ['required', 'min:3', 'max:10000'],
        ];
    }
}
