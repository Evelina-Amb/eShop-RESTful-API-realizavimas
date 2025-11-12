<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salis;

class SalisController extends Controller
{
    public function index() { return Salis::all(); }

    public function show($id) { return Salis::findOrFail($id); }

    public function store(Request $request)
    {
        $data = $request->validate(['pavadinimas' => 'required|string|max:100']);
        $salis = Salis::create($data);
        return response()->json($salis, 201);
    }

    public function update(Request $request, $id)
    {
        $salis = Salis::findOrFail($id);
        $salis->update($request->validate(['pavadinimas' => 'required|string|max:100']));
        return $salis;
    }

    public function destroy($id)
    {
        Salis::findOrFail($id)->delete();
        return response()->json(['message' => 'Salis deleted']);
    }
}
