<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdresasRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'gatve'      => 'sometimes|string|max:100',
            'namo_nr'    => 'nullable|string|max:10',
            'buto_nr'    => 'nullable|string|max:10',
            'miestas_id' => 'sometimes|exists:miestas,id'
        ];
    }
}
