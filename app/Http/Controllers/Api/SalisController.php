<?php

namespace App\Http\Controllers\Api;

use App\Models\Salis;
use App\Http\Resources\SalisResource;
use App\Http\Requests\StoreSalisRequest;
use App\Http\Requests\UpdateSalisRequest;

class SalisController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(SalisResource::collection(Salis::all()), 'Šalys gautos.');
    }

    public function show($id)
    {
        $salis = Salis::find($id);
        if (!$salis) return $this->sendError('Šalis nerasta', 404);

        return $this->sendResponse(new SalisResource($salis), 'Šalis rasta.');
    }

    public function store(StoreSalisRequest $request)
    {
        $salis = Salis::create($request->validated());
        return $this->sendResponse(new SalisResource($salis), 'Šalis sukurta.', 201);
    }

    public function update(UpdateSalisRequest $request, $id)
    {
        $salis = Salis::find($id);
        if (!$salis) return $this->sendError('Šalis nerasta', 404);

        $salis->update($request->validated());
        return $this->sendResponse(new SalisResource($salis), 'Šalis atnaujinta.');
    }

    public function destroy($id)
    {
        $salis = Salis::find($id);
        if (!$salis) return $this->sendError('Šalis nerasta', 404);

        $salis->delete();
        return $this->sendResponse(null, 'Šalis ištrinta.');
    }
}
