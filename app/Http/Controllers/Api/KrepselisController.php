<?php

namespace App\Http\Controllers\Api;

use App\Models\Krepselis;
use Illuminate\Http\Request;
use App\Http\Resources\KrepselisResource;

class KrepselisController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(
            KrepselisResource::collection(Krepselis::with(['user', 'skelbimas'])->get()),
            'Krepšelio turinys sėkmingai gautas.'
        );
    }

    public function show($id)
    {
        $item = Krepselis::with(['user', 'skelbimas'])->find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        return $this->sendResponse(new KrepselisResource($item), 'Krepšelio įrašas rastas.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'skelbimas_id' => 'required|exists:skelbimai,id',
            'kiekis' => 'required|integer|min:1'
        ]);

        $item = Krepselis::create($data);
        return $this->sendResponse(new KrepselisResource($item), 'Pridėta į krepšelį.', 201);
    }

    public function update(Request $request, $id)
    {
        $item = Krepselis::find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        $item->update($request->validate(['kiekis' => 'required|integer|min:1']));
        return $this->sendResponse(new KrepselisResource($item), 'Krepšelio įrašas atnaujintas.');
    }

    public function destroy($id)
    {
        $item = Krepselis::find($id);
        if (!$item) return $this->sendError('Krepšelio įrašas nerastas', 404);

        $item->delete();
        return $this->sendResponse(null, 'Prekė pašalinta iš krepšelio.');
    }
}
