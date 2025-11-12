<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalisRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'pavadinimas' => 'sometimes|string|max:100|unique:salis,pavadinimas,' . $this->route('id')
        ];
    }
}
