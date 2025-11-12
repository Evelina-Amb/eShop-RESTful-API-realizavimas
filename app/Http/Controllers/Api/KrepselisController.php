<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krepselis;

class KrepselisController extends Controller
{
    public function index() { return Krepselis::with(['user', 'skelbimas'])->get(); }

    public function show($id) { return Krepselis::with(['user', 'skelbimas'])->findOrFail($id); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kiekis' => 'required|integer|min:1'
        ]);
        $item = Krepselis::create($data);
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Krepselis::findOrFail($id);
        $item->update($request->validate(['kiekis' => 'required|integer|min:1']));
        return $item;
    }

    public function destroy($id)
    {
        Krepselis::findOrFail($id)->delete();
        return response()->json(['message' => 'Prekė pašalinta iš krepšelio']);
    }
}
