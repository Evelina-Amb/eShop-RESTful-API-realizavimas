<?php

namespace App\Http\Controllers\Api;

use App\Models\Isiminti;
use Illuminate\Http\Request;
use App\Http\Resources\IsimintiResource;

class IsimintiController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            IsimintiResource::collection(Isiminti::with(['user', 'skelbimas'])->get()),
            'Įsiminti skelbimai gauti.'
        );
    }

    public function show($id)
    {
        $item = Isiminti::with(['user', 'skelbimas'])->find($id);
        if (!$item) return $this->sendError('Įsimintas įrašas nerastas', 404);

        return $this->sendResponse(new IsimintiResource($item), 'Įsimintas įrašas rastas.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'skelbimas_id' => 'required|exists:skelbimai,id'
        ]);

        $item = Isiminti::create($data);
        return $this->sendResponse(new IsimintiResource($item), 'Skelbimas įsimintas.', 201);
    }

    public function destroy($id)
    {
        $item = Isiminti::find($id);
        if (!$item) return $this->sendError('Įsimintas įrašas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Skelbimas pašalintas iš įsimintų.');
    }
}
