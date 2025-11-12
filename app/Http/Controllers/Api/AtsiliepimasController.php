<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atsiliepimas;

class AtsiliepimasController extends Controller
{
    //GET api/atsiliepimai
     function index()
    {
        $atsiliepimai = Atsiliepimas::with(['user', 'skelbimas'])->get();
        return response()->json($atsiliepimai);
    }


     //GET /api/atsiliepimai/{id}
    public function show($id)
    {
        $atsiliepimas = Atsiliepimas::with(['user', 'skelbimas'])->findOrFail($id);
        return response()->json($atsiliepimas);
    }

    //POST /api/atsiliepimai
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ivertinimas' => 'required|integer|min:1|max:5',
            'komentaras' => 'nullable|string',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $atsiliepimas = Atsiliepimas::create($validated);

        return response()->json($atsiliepimas, 201);
    }

    //PUT /api/atsiliepimai/{id}

    public function update(Request $request, $id)
    {
        $atsiliepimas = Atsiliepimas::findOrFail($id);

        $validated = $request->validate([
            'ivertinimas' => 'sometimes|integer|min:1|max:5',
            'komentaras' => 'nullable|string',
        ]);

        $atsiliepimas->update($validated);

        return response()->json($atsiliepimas);
    }

    //DELETE /api/atsiliepimai/{id}
    public function destroy($id)
    {
        $atsiliepimas = Atsiliepimas::findOrFail($id);
        $atsiliepimas->delete();

        return response()->json(['message' => 'Atsiliepimas sėkmingai ištrintas']);
    }
}

