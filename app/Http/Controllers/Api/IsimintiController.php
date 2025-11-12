<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Isiminti;
use App\Http\Resources\IsimintiResource;

class IsimintiController extends Controller
{
    public function index()
    {
        return IsimintiResource::collection(Isiminti::with(['user', 'skelbimas'])->get());
    }

    public function show($id)
    {
        return new IsimintiResource(Isiminti::with(['user', 'skelbimas'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'skelbimas_id' => 'required|exists:skelbimai,id'
        ]);
        return new IsimintiResource(Isiminti::create($data));
    }

    public function destroy($id)
    {
        Isiminti::findOrFail($id)->delete();
        return response()->json(['message' => 'Išimta iš įsimintų']);
    }
}
