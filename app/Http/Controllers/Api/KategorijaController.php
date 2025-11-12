<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategorija;
use App\Http\Resources\KategorijaResource;

class KategorijaController extends Controller
{
    public function index()
    {
        return KategorijaResource::collection(Kategorija::all());
    }

    public function show($id)
    {
        return new KategorijaResource(Kategorija::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pavadinimas' => 'required|string|max:100',
            'aprasymas' => 'nullable|string|max:255',
            'tipo_zenklas' => 'required|string|in:preke,paslauga'
        ]);
        return new KategorijaResource(Kategorija::create($data));
    }

    public function update(Request $request, $id)
    {
        $kat = Kategorija::findOrFail($id);
        $kat->update($request->validate([
            'pavadinimas' => 'required|string|max:100',
            'aprasymas' => 'nullable|string|max:255',
            'tipo_zenklas' => 'required|string|in:preke,paslauga'
        ]));
        return new KategorijaResource($kat);
    }

    public function destroy($id)
    {
        Kategorija::findOrFail($id)->delete();
        return response()->json(['message' => 'Kategorija deleted']);
    }
}
