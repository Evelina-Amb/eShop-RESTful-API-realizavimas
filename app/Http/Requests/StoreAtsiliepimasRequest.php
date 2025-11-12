<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtsiliepimasRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ivertinimas'  => 'required|integer|min:1|max:5',
            'komentaras'   => 'nullable|string',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'user_id'      => 'required|exists:users,id'
        ];
    }
}
