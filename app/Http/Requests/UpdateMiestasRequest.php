<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMiestasRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'pavadinimas' => 'sometimes|string|max:100',
            'salis_id'    => 'sometimes|exists:salis,id'
        ];
    }
}
