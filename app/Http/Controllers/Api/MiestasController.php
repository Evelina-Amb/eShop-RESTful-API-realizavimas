<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Miestas;
use App\Http\Resources\MiestasResource;

class MiestasController extends Controller
{
    public function index() {  return MiestasResource::collection(Miestas::with('salis')->get());}

    public function show($id) { return new MiestasResource(Miestas::with('salis')->findOrFail($id)); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pavadinimas' => 'required|string|max:100',
            'salis_id' => 'required|exists:salis,id'
        ]);
       return new MiestasResource(Miestas::create($data));
    }

    public function update(Request $request, $id)
    {
        $miestas = Miestas::findOrFail($id);
        $miestas->update($request->validate([
            'pavadinimas' => 'required|string|max:100',
            'salis_id' => 'required|exists:salis,id'
        ]));
        return new MiestasResource($miestas);
    }

    public function destroy($id)
    {
        Miestas::findOrFail($id)->delete();
        return response()->json(['message' => 'Miestas deleted']);
    }
}
