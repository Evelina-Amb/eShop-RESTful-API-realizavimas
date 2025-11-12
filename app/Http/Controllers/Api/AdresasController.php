<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adresas;
use App\Http\Resources\AdresasResource;

class AdresasController extends Controller
{
    public function index()
    {
        return AdresasResource::collection(Adresas::with('miestas')->get());
    }

    public function show($id)
    {
        return new AdresasResource(Adresas::with('miestas')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gatve' => 'required|string|max:100',
            'namo_nr' => 'nullable|string|max:10',
            'buto_nr' => 'nullable|string|max:10',
            'miestas_id' => 'required|exists:miestas,id'
        ]);
        return new AdresasResource(Adresas::create($data));
    }

    public function update(Request $request, $id)
    {
        $adresas = Adresas::findOrFail($id);
        $adresas->update($request->validate([
            'gatve' => 'required|string|max:100',
            'namo_nr' => 'nullable|string|max:10',
            'buto_nr' => 'nullable|string|max:10',
            'miestas_id' => 'required|exists:miestas,id'
        ]));
        return new AdresasResource($adresas);
    }

    public function destroy($id)
    {
        Adresas::findOrFail($id)->delete();
        return response()->json(['message' => 'Adresas deleted']);
    }
}
