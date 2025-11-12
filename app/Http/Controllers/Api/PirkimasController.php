<?php

namespace App\Http\Controllers\Api;

use App\Models\Pirkimas;
use App\Http\Resources\PirkimasResource;
use App\Http\Requests\StorePirkimasRequest;
use App\Http\Requests\UpdatePirkimasRequest;

class PirkimasController extends BaseController
{
    public function index()
    {
        $pirkimai = Pirkimas::with(['user', 'prekes'])->get();
        return $this->sendResponse(PirkimasResource::collection($pirkimai), 'Pirkimai gauti.');
    }

    public function show($id)
    {
        $pirkimas = Pirkimas::with(['user', 'prekes'])->find($id);
        if (!$pirkimas) return $this->sendError('Pirkimas nerastas', 404);

        return $this->sendResponse(new PirkimasResource($pirkimas), 'Pirkimas rastas.');
    }

    public function store(StorePirkimasRequest $request)
    {
        $pirkimas = Pirkimas::create($request->validated());
        return $this->sendResponse(new PirkimasResource($pirkimas), 'Pirkimas sukurtas.', 201);
    }

    public function update(UpdatePirkimasRequest $request, $id)
    {
        $pirkimas = Pirkimas::find($id);
        if (!$pirkimas) return $this->sendError('Pirkimas nerastas', 404);

        $pirkimas->update($request->validated());
        return $this->sendResponse(new PirkimasResource($pirkimas), 'Pirkimas atnaujintas.');
    }

    public function destroy($id)
    {
        $pirkimas = Pirkimas::find($id);
        if (!$pirkimas) return $this->sendError('Pirkimas nerastas', 404);

        $pirkimas->delete();
        return $this->sendResponse(null, 'Pirkimas ištrintas.');
    }
}
