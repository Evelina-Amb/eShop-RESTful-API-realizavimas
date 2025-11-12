<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Miestas;
use App\Http\Resources\MiestasResource;

class MiestasController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            MiestasResource::collection(Miestas::with('salis')->get()),
            'Miestai sėkmingai gauti.'
        );
    }

    public function show($id)
    {
        $miestas = Miestas::with('salis')->find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);
        return $this->sendResponse(new MiestasResource($miestas), 'Miestas rastas.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pavadinimas' => 'required|string|max:100',
            'salis_id' => 'required|exists:salis,id'
        ]);
        $miestas = Miestas::create($data);
        return $this->sendResponse(new MiestasResource($miestas), 'Miestas sukurtas.', 201);
    }

    public function update(Request $request, $id)
    {
        $miestas = Miestas::find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);
        $miestas->update($request->validate([
            'pavadinimas' => 'required|string|max:100',
            'salis_id' => 'required|exists:salis,id'
        ]));
        return $this->sendResponse(new MiestasResource($miestas), 'Miestas atnaujintas.');
    }

    public function destroy($id)
    {
        $miestas = Miestas::find($id);
        if (!$miestas) return $this->sendError('Miestas nerastas', 404);
        $miestas->delete();
        return $this->sendResponse(null, 'Miestas ištrintas.');
    }
}