<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SkelbimuNuotrauka;

class SkelbimuNuotraukaController extends Controller
{
    public function index() { return SkelbimuNuotrauka::with('skelbimas')->get(); }

    public function show($id) { return SkelbimuNuotrauka::with('skelbimas')->findOrFail($id); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'failo_url' => 'required|string|max:255'
        ]);
        $photo = SkelbimuNuotrauka::create($data);
        return response()->json($photo, 201);
    }

    public function update(Request $request, $id)
    {
        $photo = SkelbimuNuotrauka::findOrFail($id);
        $photo->update($request->validate([
            'failo_url' => 'required|string|max:255'
        ]));
        return $photo;
    }

    public function destroy($id)
    {
        SkelbimuNuotrauka::findOrFail($id)->delete();
        return response()->json(['message' => 'Nuotrauka deleted']);
    }
}
