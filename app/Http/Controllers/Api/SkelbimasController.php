<?php

namespace App\Http\Controllers\Api;

use App\Models\Skelbimas;
use App\Http\Resources\SkelbimasResource;
use App\Http\Requests\StoreSkelbimasRequest;
use App\Http\Requests\UpdateSkelbimasRequest;

class SkelbimasController extends BaseController
{
    public function index()
    {
        $skelbimai = Skelbimas::with(['user', 'kategorija', 'nuotraukos'])->get();
        return $this->sendResponse(SkelbimasResource::collection($skelbimai), 'Visi skelbimai sėkmingai gauti.');
    }

    public function show($id)
    {
        $skelbimas = Skelbimas::with(['user', 'kategorija', 'nuotraukos'])->find($id);
        if (!$skelbimas) return $this->sendError('Skelbimas nerastas', 404);

        return $this->sendResponse(new SkelbimasResource($skelbimas), 'Skelbimas rastas.');
    }

    public function store(StoreSkelbimasRequest $request)
    {
        $skelbimas = Skelbimas::create($request->validated());
        return $this->sendResponse(new SkelbimasResource($skelbimas), 'Skelbimas sukurtas sėkmingai.', 201);
    }

    public function update(UpdateSkelbimasRequest $request, $id)
    {
        $skelbimas = Skelbimas::find($id);
        if (!$skelbimas) return $this->sendError('Skelbimas nerastas', 404);

        $skelbimas->update($request->validated());
        return $this->sendResponse(new SkelbimasResource($skelbimas), 'Skelbimas atnaujintas.');
    }

    public function destroy($id)
    {
        $skelbimas = Skelbimas::find($id);
        if (!$skelbimas) return $this->sendError('Skelbimas nerastas', 404);

        $skelbimas->delete();
        return $this->sendResponse(null, 'Skelbimas ištrintas.');
    }
}
