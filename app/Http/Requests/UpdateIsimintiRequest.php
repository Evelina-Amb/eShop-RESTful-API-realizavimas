<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIsimintiRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'user_id'      => 'sometimes|exists:users,id',
            'skelbimas_id' => 'sometimes|exists:skelbimai,id'
        ];
    }
}
