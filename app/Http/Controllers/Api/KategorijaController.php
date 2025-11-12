<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategorija;
use App\Http\Resources\KategorijaResource;
use App\Http\Requests\StoreKategorijaRequest;
use App\Http\Requests\UpdateKategorijaRequest;

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
        $kategorija = Kategorija::find($id);
        if (!$kategorija) return $this->sendError('Kategorija nerasta', 404);

        return $this->sendResponse(new KategorijaResource($kategorija), 'Kategorija rasta.');
    }

    public function store(StoreKategorijaRequest $request)
    {
        $kategorija = Kategorija::create($request->validated());
        return $this->sendResponse(new KategorijaResource($kategorija), 'Kategorija sukurta sėkmingai.', 201);
    }

    public function update(UpdateKategorijaRequest $request, $id)
    {
        $kategorija = Kategorija::find($id);
        if (!$kategorija) return $this->sendError('Kategorija nerasta', 404);

        $kategorija->update($request->validated());
        return $this->sendResponse(new KategorijaResource($kategorija), 'Kategorija atnaujinta.');
    }

    public function destroy($id)
    {
        $kategorija = Kategorija::find($id);
        if (!$kategorija) return $this->sendError('Kategorija nerasta', 404);

        $kategorija->delete();
        return $this->sendResponse(null, 'Kategorija ištrinta.');
    }
}
