<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krepselis;
use App\Http\Resources\KrepselisResource;

class KrepselisController extends Controller
{
    public function index()
    {
        return KrepselisResource::collection(
            Krepselis::with(['user', 'skelbimas'])->get()
        );
    }

    public function show($id)
    {
        return new KrepselisResource(
            Krepselis::with(['user', 'skelbimas'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kiekis' => 'required|integer|min:1'
        ]);
        return new KrepselisResource(Krepselis::create($data));
    }

    public function update(Request $request, $id)
    {
        $item = Krepselis::findOrFail($id);
        $item->update($request->validate(['kiekis' => 'required|integer|min:1']));
        return new KrepselisResource($item);
    }

    public function destroy($id)
    {
        Krepselis::findOrFail($id)->delete();
        return response()->json(['message' => 'Pašalinta iš krepšelio']);
    }
}
