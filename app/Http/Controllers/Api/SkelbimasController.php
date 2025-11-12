<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController; 
use Illuminate\Http\Request;
use App\Models\Skelbimas;
use App\Http\Resources\SkelbimasResource;

class SkelbimasController extends BaseController
{
    // GET /api/skelbimai
    public function index()
    {
        $skelbimai = Skelbimas::with(['user', 'kategorija', 'nuotraukos'])->get();
        return $this->sendResponse(
            SkelbimasResource::collection($skelbimai),
            'Visi skelbimai sėkmingai gauti.',
            200
        );
    }

    // GET /api/skelbimai/{id}
    public function show($id)
    {
        $skelbimas = Skelbimas::with(['user', 'kategorija', 'nuotraukos'])->findOrFail($id);
        if (!$skelbimas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Skelbimas nerastas'
            ], 404);
        }

        return $this->sendResponse(
            new SkelbimasResource($skelbimas),
            'Skelbimas sėkmingai rastas.',
            200
        );
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

        return $this->sendResponse(
            new SkelbimasResource($skelbimas),
            'Skelbimas sukurtas sėkmingai.',
            201
        );
    }

    // PUT /api/skelbimai/{id}
    public function update(Request $request, $id)
    {
        $skelbimas = Skelbimas::findOrFail($id);
 if (!$skelbimas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Skelbimas nerastas'
            ], 404);
        }
        $validated = $request->validate([
            'pavadinimas'   => 'sometimes|string|max:100',
            'aprasymas'     => 'sometimes|string',
            'kaina'         => 'sometimes|numeric',
            'tipas'         => 'sometimes|string|in:preke,paslauga',
            'statusas'      => 'sometimes|string|in:aktyvus,rezervuotas,parduotas',
            'kategorija_id' => 'sometimes|exists:kategorijos,id'
        ]);

        $skelbimas->update($validated);

        return $this->sendResponse(
            new SkelbimasResource($skelbimas),
            'Skelbimas atnaujintas sėkmingai.',
            200
        );
    }

    // DELETE /api/skelbimai/{id}
    public function destroy($id)
    {
        $skelbimas = Skelbimas::findOrFail($id);
         if (!$skelbimas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Skelbimas nerastas'
            ], 404);
        }
        $skelbimas->delete();
        return $this->sendResponse(
            null,
            'Skelbimas sėkmingai ištrintas.',
            200
        );
    }
}
