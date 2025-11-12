<?php

namespace App\Http\Controllers\Api;

use App\Models\Atsiliepimas;
use Illuminate\Http\Request;
use App\Http\Resources\AtsiliepimasResource;

class AtsiliepimasController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            AtsiliepimasResource::collection(Atsiliepimas::with(['user', 'skelbimas'])->get()),
            'Atsiliepimai sėkmingai gauti.'
        );
    }

    public function show($id)
    {
        $ats = Atsiliepimas::with(['user', 'skelbimas'])->find($id);
        if (!$ats) return $this->sendError('Atsiliepimas nerastas', 404);

        return $this->sendResponse(new AtsiliepimasResource($ats), 'Atsiliepimas rastas.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ivertinimas' => 'required|integer|min:1|max:5',
            'komentaras' => 'nullable|string',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $ats = Atsiliepimas::create($data);
        return $this->sendResponse(new AtsiliepimasResource($ats), 'Atsiliepimas sukurtas.', 201);
    }

    public function update(Request $request, $id)
    {
        $ats = Atsiliepimas::find($id);
        if (!$ats) return $this->sendError('Atsiliepimas nerastas', 404);

        $ats->update($request->validate([
            'ivertinimas' => 'sometimes|integer|min:1|max:5',
            'komentaras' => 'nullable|string'
        ]));

        return $this->sendResponse(new AtsiliepimasResource($ats), 'Atsiliepimas atnaujintas.');
    }

    public function destroy($id)
    {
        $ats = Atsiliepimas::find($id);
        if (!$ats) return $this->sendError('Atsiliepimas nerastas', 404);

        $ats->delete();
        return $this->sendResponse(null, 'Atsiliepimas ištrintas.');
    }
}
