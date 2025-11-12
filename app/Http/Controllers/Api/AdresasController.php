<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adresas;

class AdresasController extends Controller
{
    public function index() { return Adresas::with('miestas')->get(); }

    public function show($id) { return Adresas::with('miestas')->findOrFail($id); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gatve' => 'required|string|max:100',
            'namo_nr' => 'nullable|string|max:10',
            'buto_nr' => 'nullable|string|max:10',
            'miestas_id' => 'required|exists:miestas,id'
        ]);
        $adresas = Adresas::create($data);
        return response()->json($adresas, 201);
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
        return $adresas;
    }

    public function destroy($id)
    {
        Adresas::findOrFail($id)->delete();
        return response()->json(['message' => 'Adresas deleted']);
    }
}
