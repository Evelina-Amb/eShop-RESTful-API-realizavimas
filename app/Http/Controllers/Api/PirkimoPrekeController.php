<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PirkimoPreke;

class PirkimoPrekeController extends Controller
{
    public function index() { return PirkimoPreke::with(['pirkimas', 'skelbimas'])->get(); }

    public function show($id) { return PirkimoPreke::with(['pirkimas', 'skelbimas'])->findOrFail($id); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pirkimas_id' => 'required|exists:pirkimai,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kaina' => 'required|numeric|min:0',
            'kiekis' => 'required|integer|min:1'
        ]);
        $preke = PirkimoPreke::create($data);
        return response()->json($preke, 201);
    }

    public function update(Request $request, $id)
    {
        $preke = PirkimoPreke::findOrFail($id);
        $preke->update($request->validate([
            'kaina' => 'sometimes|numeric|min:0',
            'kiekis' => 'sometimes|integer|min:1'
        ]));
        return $preke;
    }

    public function destroy($id)
    {
        PirkimoPreke::findOrFail($id)->delete();
        return response()->json(['message' => 'Pirkimo prekė deleted']);
    }
}
