<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalisRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'pavadinimas' => 'required|string|max:100|unique:salis,pavadinimas'
        ];
    }
}
