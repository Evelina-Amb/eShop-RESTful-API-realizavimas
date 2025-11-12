<?php

namespace App\Http\Controllers\Api;

use App\Models\Pirkimas;
use Illuminate\Http\Request;
use App\Http\Resources\PirkimasResource;

class PirkimasController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            PirkimasResource::collection(Pirkimas::with(['user', 'prekes'])->get()),
            'Pirkimai sėkmingai gauti.'
        );
    }

    public function show($id)
    {
        $pirkimas = Pirkimas::with(['user', 'prekes'])->find($id);
        if (!$pirkimas) return $this->sendError('Pirkimas nerastas', 404);

        return $this->sendResponse(new PirkimasResource($pirkimas), 'Pirkimas rastas.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bendra_suma' => 'required|numeric|min:0',
            'statusas' => 'required|string|in:completed,canceled,refunded'
        ]);

        $pirkimas = Pirkimas::create($data);
        return $this->sendResponse(new PirkimasResource($pirkimas), 'Pirkimas sukurtas.', 201);
    }

    public function update(Request $request, $id)
    {
        $pirkimas = Pirkimas::find($id);
        if (!$pirkimas) return $this->sendError('Pirkimas nerastas', 404);

        $pirkimas->update($request->validate([
            'statusas' => 'required|string|in:completed,canceled,refunded'
        ]));

        return $this->sendResponse(new PirkimasResource($pirkimas), 'Pirkimas atnaujintas.');
    }

    public function destroy($id)
    {
        $pirkimas = Pirkimas::find($id);
        if (!$pirkimas) return $this->sendError('Pirkimas nerastas', 404);

        $pirkimas->delete();
        return $this->sendResponse(null, 'Pirkimas ištrintas.');
    }
}
