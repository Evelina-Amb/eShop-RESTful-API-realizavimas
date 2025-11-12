<?php

namespace App\Http\Controllers\Api;

use App\Models\Adresas;
use App\Http\Resources\AdresasResource;
use App\Http\Requests\StoreAdresasRequest;
use App\Http\Requests\UpdateAdresasRequest;

class AdresasController extends BaseController
{
    public function index()
    {
        $adresai = Adresas::with('miestas.salis')->get();
        return $this->sendResponse(AdresasResource::collection($adresai), 'Adresai gauti.');
    }

    public function show($id)
    {
        $adresas = Adresas::with('miestas.salis')->find($id);
        if (!$adresas) return $this->sendError('Adresas nerastas', 404);

        return $this->sendResponse(new AdresasResource($adresas), 'Adresas rastas.');
    }

    public function store(StoreAdresasRequest $request)
    {
        $adresas = Adresas::create($request->validated());
        return $this->sendResponse(new AdresasResource($adresas), 'Adresas sukurtas.', 201);
    }

    public function update(UpdateAdresasRequest $request, $id)
    {
        $adresas = Adresas::find($id);
        if (!$adresas) return $this->sendError('Adresas nerastas', 404);

        $adresas->update($request->validated());
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
