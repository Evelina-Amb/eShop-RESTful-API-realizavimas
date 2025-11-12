<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkelbimuNuotraukaRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'failo_url'    => 'required|string|max:255'
        ];
    }
}

