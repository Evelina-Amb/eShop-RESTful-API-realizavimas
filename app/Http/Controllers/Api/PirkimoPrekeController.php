<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PirkimoPreke;
use App\Http\Resources\PirkimoPrekeResource;

class PirkimoPrekeController extends Controller
{
    public function index()
    {
        return PirkimoPrekeResource::collection(
            PirkimoPreke::with(['pirkimas', 'skelbimas'])->get()
        );
    }

    public function show($id)
    {
        return new PirkimoPrekeResource(
            PirkimoPreke::with(['pirkimas', 'skelbimas'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pirkimas_id' => 'required|exists:pirkimai,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kaina' => 'required|numeric|min:0',
            'kiekis' => 'required|integer|min:1'
        ]);
        return new PirkimoPrekeResource(PirkimoPreke::create($data));
    }

    public function update(Request $request, $id)
    {
        $preke = PirkimoPreke::findOrFail($id);
        $preke->update($request->validate([
            'kaina' => 'sometimes|numeric|min:0',
            'kiekis' => 'sometimes|integer|min:1'
        ]));
        return new PirkimoPrekeResource($preke);
    }

    public function destroy($id)
    {
        PirkimoPreke::findOrFail($id)->delete();
        return response()->json(['message' => 'Pirkimo prekė deleted']);
    }
}
