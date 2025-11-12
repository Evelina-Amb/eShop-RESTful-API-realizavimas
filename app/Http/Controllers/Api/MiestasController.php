<?php

namespace App\Http\Controllers\Api;

use App\Models\Miestas;
use App\Http\Resources\MiestasResource;
use App\Http\Requests\StoreMiestasRequest;
use App\Http\Requests\UpdateMiestasRequest;

class MiestasController extends BaseController
{
    public function index()
    {
        $miestai = Miestas::with('salis')->get();
        return $this->sendResponse(MiestasResource::collection($miestai), 'Miestai gauti.');
    }

    public function show($id)
    {
        $miestas = Miestas::with('salis')->find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);

        return $this->sendResponse(new MiestasResource($miestas), 'Miestas rastas.');
    }

    public function store(StoreMiestasRequest $request)
    {
        $miestas = Miestas::create($request->validated());
        return $this->sendResponse(new MiestasResource($miestas), 'Miestas sukurtas.', 201);
    }

    public function update(UpdateMiestasRequest $request, $id)
    {
        $miestas = Miestas::find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);

        $miestas->update($request->validated());
        return $this->sendResponse(new MiestasResource($miestas), 'Miestas atnaujintas.');
    }

    public function destroy($id)
    {
        $miestas = Miestas::find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);

        $miestas->delete();
        return $this->sendResponse(null, 'Miestas ištrintas.');
    }
}
