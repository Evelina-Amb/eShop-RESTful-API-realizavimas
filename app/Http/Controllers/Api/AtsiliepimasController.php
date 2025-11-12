<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atsiliepimas;
use App\Http\Resources\AtsiliepimasResource;

class AtsiliepimasController extends Controller
{
    public function index()
    {
        return AtsiliepimasResource::collection(
            Atsiliepimas::with(['user', 'skelbimas'])->get()
        );
    }

    public function show($id)
    {
        return new AtsiliepimasResource(
            Atsiliepimas::with(['user', 'skelbimas'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ivertinimas' => 'required|integer|min:1|max:5',
            'komentaras' => 'nullable|string',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'user_id' => 'required|exists:users,id'
        ]);
        return new AtsiliepimasResource(Atsiliepimas::create($data));
    }

    public function update(Request $request, $id)
    {
        $ats = Atsiliepimas::findOrFail($id);
        $ats->update($request->validate([
            'ivertinimas' => 'sometimes|integer|min:1|max:5',
            'komentaras' => 'nullable|string'
        ]));
        return new AtsiliepimasResource($ats);
    }

    public function destroy($id)
    {
        Atsiliepimas::findOrFail($id)->delete();
        return response()->json(['message' => 'Atsiliepimas deleted']);
    }
}
