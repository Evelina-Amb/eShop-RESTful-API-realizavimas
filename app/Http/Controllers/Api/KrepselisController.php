<?php

namespace App\Http\Controllers\Api;

use App\Models\Krepselis;
use App\Http\Resources\KrepselisResource;
use App\Http\Requests\StoreKrepselisRequest;
use App\Http\Requests\UpdateKrepselisRequest;

class KrepselisController extends BaseController
{
    public function index()
    {
        $krepselis = Krepselis::with(['user', 'skelbimas'])->get();
        return $this->sendResponse(KrepselisResource::collection($krepselis), 'Krepšelis gautas.');
    }

    public function show($id)
    {
        $item = Krepselis::with(['user', 'skelbimas'])->find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        return $this->sendResponse(new KrepselisResource($item), 'Krepšelio įrašas rastas.');
    }

    public function store(StoreKrepselisRequest $request)
    {
        $item = Krepselis::create($request->validated());
        return $this->sendResponse(new KrepselisResource($item), 'Prekė pridėta į krepšelį.', 201);
    }

    public function update(UpdateKrepselisRequest $request, $id)
    {
        $item = Krepselis::find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        $item->update($request->validated());
        return $this->sendResponse(new KrepselisResource($item), 'Krepšelio įrašas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Krepselis::find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Prekė pašalinta iš krepšelio.');
    }
}
