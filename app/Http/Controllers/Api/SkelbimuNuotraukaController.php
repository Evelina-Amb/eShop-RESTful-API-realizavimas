<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SkelbimuNuotrauka;
use App\Http\Resources\SkelbimuNuotraukaResource;

class SkelbimuNuotraukaController extends Controller
{
    public function index()
    {
        return SkelbimuNuotraukaResource::collection(
            SkelbimuNuotrauka::with('skelbimas')->get()
        );
    }

    public function show($id)
    {
        return new SkelbimuNuotraukaResource(
            SkelbimuNuotrauka::with('skelbimas')->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'failo_url' => 'required|string|max:255'
        ]);
        return new SkelbimuNuotraukaResource(SkelbimuNuotrauka::create($data));
    }

    public function update(Request $request, $id)
    {
        $photo = SkelbimuNuotrauka::findOrFail($id);
        $photo->update($request->validate(['failo_url' => 'required|string|max:255']));
        return new SkelbimuNuotraukaResource($photo);
    }

    public function destroy($id)
    {
        SkelbimuNuotrauka::findOrFail($id)->delete();
        return response()->json(['message' => 'Nuotrauka deleted']);
    }
}
