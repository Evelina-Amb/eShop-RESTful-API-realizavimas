<?php

namespace App\Http\Controllers\Api;

use App\Models\Isiminti;
use App\Http\Resources\IsimintiResource;
use App\Http\Requests\StoreIsimintiRequest;
use App\Http\Requests\UpdateIsimintiRequest;

class IsimintiController extends BaseController
{
    public function index()
    {
        $isiminti = Isiminti::with(['user', 'skelbimas'])->get();
        return $this->sendResponse(IsimintiResource::collection($isiminti), 'Įsiminti skelbimai gauti.');
    }

    public function show($id)
    {
        $isimintas = Isiminti::with(['user', 'skelbimas'])->find($id);
        if (!$isimintas) return $this->sendError('Įsimintas skelbimas nerastas', 404);

        return $this->sendResponse(new IsimintiResource($isimintas), 'Įsimintas skelbimas rastas.');
    }

    public function store(StoreIsimintiRequest $request)
    {
        $isimintas = Isiminti::create($request->validated());
        return $this->sendResponse(new IsimintiResource($isimintas), 'Skelbimas įsimintas.', 201);
    }

    public function update(UpdateIsimintiRequest $request, $id)
    {
        $isimintas = Isiminti::find($id);
        if (!$isimintas) return $this->sendError('Įsimintas skelbimas nerastas', 404);

        $isimintas->update($request->validated());
        return $this->sendResponse(new IsimintiResource($isimintas), 'Įsimintas skelbimas atnaujintas.');
    }

    public function destroy($id)
    {
        $isimintas = Isiminti::find($id);
        if (!$isimintas) return $this->sendError('Įsimintas skelbimas nerastas', 404);

        $isimintas->delete();
        return $this->sendResponse(null, 'Skelbimas pašalintas iš įsimintų.');
    }
}
