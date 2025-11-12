<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adresas;
use App\Http\Resources\AdresasResource;

class AdresasController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            AdresasResource::collection(Adresas::with('miestas.salis')->get()),
            'Adresai sėkmingai gauti.'
        );
    }

    public function show($id)
    {
        $adresas = Adresas::with('miestas.salis')->find($id);
        if (!$adresas) return $this->sendError('Adresas nerastas', 404);
        return $this->sendResponse(new AdresasResource($adresas), 'Adresas rastas.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gatve' => 'required|string|max:100',
            'namo_nr' => 'nullable|string|max:10',
            'buto_nr' => 'nullable|string|max:10',
            'miestas_id' => 'required|exists:miestas,id'
        ]);
        $adresas = Adresas::create($data);
        return $this->sendResponse(new AdresasResource($adresas), 'Adresas sukurtas.', 201);
    }

    public function update(Request $request, $id)
    {
        $adresas = Adresas::find($id);
        if (!$adresas) return $this->sendError('Adresas nerastas', 404);
        $adresas->update($request->validate([
            'gatve' => 'required|string|max:100',
            'namo_nr' => 'nullable|string|max:10',
            'buto_nr' => 'nullable|string|max:10',
            'miestas_id' => 'required|exists:miestas,id'
        ]));
        return $this->sendResponse(new AdresasResource($adresas), 'Adresas atnaujintas.');
    }

    public function destroy($id)
    {
        $adresas = Adresas::find($id);
        if (!$adresas) return $this->sendError('Adresas nerastas', 404);
        $adresas->delete();
        return $this->sendResponse(null, 'Adresas ištrintas.');
    }
}