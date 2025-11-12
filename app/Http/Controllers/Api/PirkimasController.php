<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pirkimas;
use App\Http\Resources\PirkimasResource;

class PirkimasController extends Controller
{
    public function index()
    {
        return PirkimasResource::collection(Pirkimas::with(['user', 'prekes'])->get());
    }

    public function show($id)
    {
        return new PirkimasResource(Pirkimas::with(['user', 'prekes'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bendra_suma' => 'required|numeric|min:0',
            'statusas' => 'required|string|in:completed,canceled,refunded'
        ]);
        return new PirkimasResource(Pirkimas::create($data));
    }

    public function update(Request $request, $id)
    {
        $pirkimas = Pirkimas::findOrFail($id);
        $pirkimas->update($request->validate([
            'statusas' => 'required|string|in:completed,canceled,refunded'
        ]));
        return new PirkimasResource($pirkimas);
    }

    public function destroy($id)
    {
        Pirkimas::findOrFail($id)->delete();
        return response()->json(['message' => 'Pirkimas deleted']);
    }
}
