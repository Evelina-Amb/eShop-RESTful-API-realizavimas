<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salis;
use App\Http\Resources\SalisResource;

class SalisController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(SalisResource::collection(Salis::all()), 'Šalys sėkmingai gautos.');
    }

    public function show($id)
    {
        $salis = Salis::find($id);
        if (!$salis) return $this->sendError('Šalis nerasta', 404);
        return $this->sendResponse(new SalisResource($salis), 'Šalis sėkmingai rasta.');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['pavadinimas' => 'required|string|max:100']);
        $salis = Salis::create($data);
        return $this->sendResponse(new SalisResource($salis), 'Šalis sukurta sėkmingai.', 201);
    }

    public function update(Request $request, $id)
    {
        $salis = Salis::find($id);
        if (!$salis) return $this->sendError('Šalis nerasta', 404);
        $salis->update($request->validate(['pavadinimas' => 'required|string|max:100']));
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
