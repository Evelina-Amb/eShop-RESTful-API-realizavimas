<?php

namespace App\Http\Controllers\Api;

use App\Models\PirkimoPreke;
use Illuminate\Http\Request;
use App\Http\Resources\PirkimoPrekeResource;

class PirkimoPrekeController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            PirkimoPrekeResource::collection(PirkimoPreke::with(['pirkimas', 'skelbimas'])->get()),
            'Pirkimo prekės sėkmingai gautos.'
        );
    }

    public function show($id)
    {
        $item = PirkimoPreke::with(['pirkimas', 'skelbimas'])->find($id);
        if (!$item) return $this->sendError('Pirkimo prekė nerasta', 404);

        return $this->sendResponse(new PirkimoPrekeResource($item), 'Pirkimo prekė rasta.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pirkimas_id' => 'required|exists:pirkimai,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kaina' => 'required|numeric|min:0',
            'kiekis' => 'required|integer|min:1'
        ]);

        $item = PirkimoPreke::create($data);
        return $this->sendResponse(new PirkimoPrekeResource($item), 'Pirkimo prekė pridėta.', 201);
    }

    public function update(Request $request, $id)
    {
        $item = PirkimoPreke::find($id);
        if (!$item) return $this->sendError('Pirkimo prekė nerasta', 404);

        $item->update($request->validate([
            'kaina' => 'sometimes|numeric|min:0',
            'kiekis' => 'sometimes|integer|min:1'
        ]));

        return $this->sendResponse(new PirkimoPrekeResource($item), 'Pirkimo prekė atnaujinta.');
    }

    public function destroy($id)
    {
        $item = PirkimoPreke::find($id);
        if (!$item) return $this->sendError('Pirkimo prekė nerasta', 404);

        $item->delete();
        return $this->sendResponse(null, 'Pirkimo prekė ištrinta.');
    }
}
