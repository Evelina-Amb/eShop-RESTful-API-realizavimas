<?php

namespace App\Http\Controllers\Api;

use App\Models\SkelbimuNuotrauka;
use Illuminate\Http\Request;
use App\Http\Resources\SkelbimuNuotraukaResource;

class SkelbimuNuotraukaController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            SkelbimuNuotraukaResource::collection(SkelbimuNuotrauka::with('skelbimas')->get()),
            'Nuotraukos sėkmingai gautos.'
        );
    }

    public function show($id)
    {
        $foto = SkelbimuNuotrauka::with('skelbimas')->find($id);
        if (!$foto) return $this->sendError('Nuotrauka nerasta', 404);

        return $this->sendResponse(new SkelbimuNuotraukaResource($foto), 'Nuotrauka rasta.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'failo_url' => 'required|string|max:255'
        ]);

        $foto = SkelbimuNuotrauka::create($data);
        return $this->sendResponse(new SkelbimuNuotraukaResource($foto), 'Nuotrauka įkelta.', 201);
    }

    public function update(Request $request, $id)
    {
        $foto = SkelbimuNuotrauka::find($id);
        if (!$foto) return $this->sendError('Nuotrauka nerasta', 404);

        $foto->update($request->validate([
            'failo_url' => 'required|string|max:255'
        ]));

        return $this->sendResponse(new SkelbimuNuotraukaResource($foto), 'Nuotrauka atnaujinta.');
    }

    public function destroy($id)
    {
        $foto = SkelbimuNuotrauka::find($id);
        if (!$foto) return $this->sendError('Nuotrauka nerasta', 404);

        $foto->delete();
        return $this->sendResponse(null, 'Nuotrauka ištrinta.');
    }
}
