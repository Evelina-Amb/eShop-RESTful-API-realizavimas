<?php

namespace App\Http\Controllers\Api;

use App\Models\SkelbimuNuotrauka;
use App\Http\Resources\SkelbimuNuotraukaResource;
use App\Http\Requests\StoreSkelbimuNuotraukaRequest;
use App\Http\Requests\UpdateSkelbimuNuotraukaRequest;

class SkelbimuNuotraukaController extends BaseController
{
    public function index()
    {
        $nuotraukos = SkelbimuNuotrauka::with('skelbimas')->get();
        return $this->sendResponse(
            SkelbimuNuotraukaResource::collection($nuotraukos),
            'Skelbimų nuotraukos gautos.'
        );
    }

    public function show($id)
    {
        $nuotrauka = SkelbimuNuotrauka::with('skelbimas')->find($id);
        if (!$nuotrauka) return $this->sendError('Nuotrauka nerasta', 404);

        return $this->sendResponse(new SkelbimuNuotraukaResource($nuotrauka), 'Nuotrauka rasta.');
    }

    public function store(StoreSkelbimuNuotraukaRequest $request)
    {
        $nuotrauka = SkelbimuNuotrauka::create($request->validated());
        return $this->sendResponse(new SkelbimuNuotraukaResource($nuotrauka), 'Nuotrauka įkelta.', 201);
    }

    public function update(UpdateSkelbimuNuotraukaRequest $request, $id)
    {
        $nuotrauka = SkelbimuNuotrauka::find($id);
        if (!$nuotrauka) return $this->sendError('Nuotrauka nerasta', 404);

        $nuotrauka->update($request->validated());
        return $this->sendResponse(new SkelbimuNuotraukaResource($nuotrauka), 'Nuotrauka atnaujinta.');
    }

    public function destroy($id)
    {
        $nuotrauka = SkelbimuNuotrauka::find($id);
        if (!$nuotrauka) return $this->sendError('Nuotrauka nerasta', 404);

        $nuotrauka->delete();
        return $this->sendResponse(null, 'Nuotrauka ištrinta.');
    }
}
