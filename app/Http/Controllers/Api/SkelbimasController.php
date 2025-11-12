<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skelbimas;

class SkelbimasController extends Controller
{
    // GET /api/skelbimai
    public function index()
    {
        return response()->json(
            Skelbimas::with(['user', 'kategorija'])->get()
        );
    }

    // GET /api/skelbimai/{id}
    public function show($id)
    {
        $skelbimas = Skelbimas::with(['user', 'kategorija'])->findOrFail($id);
        return response()->json($skelbimas);
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

        return response()->json($skelbimas, 201);
    }

    // PUT /api/skelbimai/{id}
    public function update(Request $request, $id)
    {
        $skelbimas = Skelbimas::findOrFail($id);
        $skelbimas->update($request->all());
        return response()->json($skelbimas);
    }

    // DELETE /api/skelbimai/{id}
    public function destroy($id)
    {
        $skelbimas = Skelbimas::findOrFail($id);
        $skelbimas->delete();
        return response()->json(['message' => 'Skelbimas deleted']);
    }
}
