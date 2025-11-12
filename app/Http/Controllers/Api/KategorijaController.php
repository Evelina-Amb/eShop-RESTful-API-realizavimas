<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategorija;
use Illuminate\Http\Request;
use App\Http\Resources\KategorijaResource;

class KategorijaController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            KategorijaResource::collection(Kategorija::all()),
            'Kategorijos sėkmingai gautos.'
        );
    }

    public function show($id)
    {
        $kat = Kategorija::find($id);
        if (!$kat) return $this->sendError('Kategorija nerasta', 404);

        return $this->sendResponse(new KategorijaResource($kat), 'Kategorija rasta.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pavadinimas' => 'required|string|max:100',
            'aprasymas' => 'nullable|string|max:255',
            'tipo_zenklas' => 'required|string|in:preke,paslauga'
        ]);

        $kat = Kategorija::create($data);
        return $this->sendResponse(new KategorijaResource($kat), 'Kategorija sukurta sėkmingai.', 201);
    }

    public function update(Request $request, $id)
    {
        $kat = Kategorija::find($id);
        if (!$kat) return $this->sendError('Kategorija nerasta', 404);

        $kat->update($request->validate([
            'pavadinimas' => 'required|string|max:100',
            'aprasymas' => 'nullable|string|max:255',
            'tipo_zenklas' => 'required|string|in:preke,paslauga'
        ]));

        return $this->sendResponse(new KategorijaResource($kat), 'Kategorija atnaujinta.');
    }

    public function destroy($id)
    {
        $kat = Kategorija::find($id);
        if (!$kat) return $this->sendError('Kategorija nerasta', 404);

        $kat->delete();
        return $this->sendResponse(null, 'Kategorija ištrinta.');
    }
}
