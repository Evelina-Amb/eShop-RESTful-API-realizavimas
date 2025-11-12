<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController; 
use Illuminate\Http\Request;
use App\Models\Skelbimas;
use App\Http\Resources\SkelbimasResource;

class SkelbimasController extends Controller
{
    // GET /api/skelbimai
    public function index()
    {
        $skelbimai = Skelbimas::with(['user', 'kategorija', 'nuotraukos'])->get();
        return SkelbimasResource::collection($skelbimai);
    }

    // GET /api/skelbimai/{id}
    public function show($id)
    {
        $skelbimas = Skelbimas::with(['user', 'kategorija', 'nuotraukos'])->findOrFail($id);
        return new SkelbimasResource($skelbimas);
    }

    // POST /api/skelbimai
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pavadinimas' => 'required|string|max:100',
            'aprasymas' => 'required|string',
            'kaina' => 'required|numeric',
            'tipas' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'kategorija_id' => 'required|exists:kategorija,id',
            'statusas' => 'nullable|string'
        ]);

        $skelbimas = Skelbimas::create($validated);

        return new SkelbimasResource($skelbimas);
    }

    // PUT /api/skelbimai/{id}
    public function update(Request $request, $id)
    {
        $skelbimas = Skelbimas::findOrFail($id);

        $validated = $request->validate([
            'pavadinimas'   => 'sometimes|string|max:100',
            'aprasymas'     => 'sometimes|string',
            'kaina'         => 'sometimes|numeric',
            'tipas'         => 'sometimes|string|in:preke,paslauga',
            'statusas'      => 'sometimes|string|in:aktyvus,rezervuotas,parduotas',
            'kategorija_id' => 'sometimes|exists:kategorijos,id'
        ]);

        $skelbimas->update($validated);

        return new SkelbimasResource($skelbimas);
    }

    // DELETE /api/skelbimai/{id}
    public function destroy($id)
    {
        $skelbimas = Skelbimas::findOrFail($id);
        $skelbimas->delete();
         return response()->json(['message' => 'Skelbimas sėkmingai ištrintas']);
    }
}
