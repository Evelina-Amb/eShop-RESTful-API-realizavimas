<?php

namespace App\Http\Controllers\Api;

use App\Models\PirkimoPreke;
use App\Http\Resources\PirkimoPrekeResource;
use App\Http\Requests\StorePirkimoPrekeRequest;
use App\Http\Requests\UpdatePirkimoPrekeRequest;

class PirkimoPrekeController extends BaseController
{
    public function index()
    {
        $prekes = PirkimoPreke::with(['pirkimas', 'skelbimas'])->get();
        return $this->sendResponse(PirkimoPrekeResource::collection($prekes), 'Pirkimo prekės gautos.');
    }

    public function show($id)
    {
        $preke = PirkimoPreke::with(['pirkimas', 'skelbimas'])->find($id);
        if (!$preke) return $this->sendError('Pirkimo prekė nerasta', 404);

        return $this->sendResponse(new PirkimoPrekeResource($preke), 'Pirkimo prekė rasta.');
    }

    public function store(StorePirkimoPrekeRequest $request)
    {
        $preke = PirkimoPreke::create($request->validated());
        return $this->sendResponse(new PirkimoPrekeResource($preke), 'Pirkimo prekė pridėta.', 201);
    }

    public function update(UpdatePirkimoPrekeRequest $request, $id)
    {
        $preke = PirkimoPreke::find($id);
        if (!$preke) return $this->sendError('Pirkimo prekė nerasta', 404);

        $preke->update($request->validated());
        return $this->sendResponse(new PirkimoPrekeResource($preke), 'Pirkimo prekė atnaujinta.');
    }

    public function destroy($id)
    {
        $preke = PirkimoPreke::find($id);
        if (!$preke) return $this->sendError('Pirkimo prekė nerasta', 404);

        $preke->delete();
        return $this->sendResponse(null, 'Pirkimo prekė ištrinta.');
    }
}
