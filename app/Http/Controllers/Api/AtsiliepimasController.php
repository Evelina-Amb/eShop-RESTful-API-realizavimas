<?php

namespace App\Http\Controllers\Api;

use App\Models\Atsiliepimas;
use App\Http\Resources\AtsiliepimasResource;
use App\Http\Requests\StoreAtsiliepimasRequest;
use App\Http\Requests\UpdateAtsiliepimasRequest;

class AtsiliepimasController extends BaseController
{
    public function index()
    {
        $atsiliepimai = Atsiliepimas::with(['user', 'skelbimas'])->get();
        return $this->sendResponse(
            AtsiliepimasResource::collection($atsiliepimai),
            'Atsiliepimai gauti.'
        );
    }

    public function show($id)
    {
        $atsiliepimas = Atsiliepimas::with(['user', 'skelbimas'])->find($id);
        if (!$atsiliepimas) return $this->sendError('Atsiliepimas nerastas', 404);

        return $this->sendResponse(new AtsiliepimasResource($atsiliepimas), 'Atsiliepimas rastas.');
    }

    public function store(StoreAtsiliepimasRequest $request)
    {
        $atsiliepimas = Atsiliepimas::create($request->validated());
        return $this->sendResponse(new AtsiliepimasResource($atsiliepimas), 'Atsiliepimas sukurtas.', 201);
    }

    public function update(UpdateAtsiliepimasRequest $request, $id)
    {
        $atsiliepimas = Atsiliepimas::find($id);
        if (!$atsiliepimas) return $this->sendError('Atsiliepimas nerastas', 404);

        $atsiliepimas->update($request->validated());
        return $this->sendResponse(new AtsiliepimasResource($atsiliepimas), 'Atsiliepimas atnaujintas.');
    }

    public function destroy($id)
    {
        $atsiliepimas = Atsiliepimas::find($id);
        if (!$atsiliepimas) return $this->sendError('Atsiliepimas nerastas', 404);

        $atsiliepimas->delete();
        return $this->sendResponse(null, 'Atsiliepimas ištrintas.');
    }
}
