<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePirkimoPrekeRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'pirkimas_id'  => 'required|exists:pirkimai,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kaina'        => 'required|numeric|min:0',
            'kiekis'       => 'required|integer|min:1'
        ];
    }
}
