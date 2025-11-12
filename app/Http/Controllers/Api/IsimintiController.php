<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Isiminti;

class IsimintiController extends Controller
{
    public function index() { return Isiminti::with(['user', 'skelbimas'])->get(); }

    public function show($id) { return Isiminti::with(['user', 'skelbimas'])->findOrFail($id); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'skelbimas_id' => 'required|exists:skelbimai,id'
        ]);
        $fav = Isiminti::create($data);
        return response()->json($fav, 201);
    }

    public function destroy($id)
    {
        Isiminti::findOrFail($id)->delete();
        return response()->json(['message' => 'Išimta iš įsimintų']);
    }
}
