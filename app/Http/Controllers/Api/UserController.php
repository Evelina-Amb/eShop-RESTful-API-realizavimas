<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    // GET /api/users
    public function index()
    {
        $users = User::with('adresas.miestas.salis')->get();
        return $this->sendResponse(UserResource::collection($users), 'Vartotojai sėkmingai gauti.');
    }

    // GET /api/users/{id}
    public function show($id)
     {
        $user = User::with('adresas.miestas.salis')->find($id);
        if (!$user) return $this->sendError('Vartotojas nerastas', 404);
        return $this->sendResponse(new UserResource($user), 'Vartotojas rastas.');
    }

    // POST /api/users
    public function store(Request $request)
    {
        $validated = $request->validate([
    'vardas' => 'required|string|max:50',
    'pavarde' => 'required|string|max:50',
    'el_pastas' => 'required|email|unique:users,el_pastas',
    'slaptazodis' => 'required|string|min:6',
    'telefonas' => 'nullable|string',
    'adresas_id' => 'nullable|exists:adresas,id',
    'role' => 'nullable|string|in:pirkejas,seller,admin'
]);

$validated['slaptazodis'] = Hash::make($validated['slaptazodis']);

$user = User::create($validated);
        return $this->sendResponse(new UserResource($user), 'Vartotojas sukurtas.', 201);
        
}

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
         $user = User::findOrFail($id);

        $data = $request->validate([
            'vardas'      => 'sometimes|string|max:50',
            'pavarde'     => 'sometimes|string|max:50',
            'el_pastas'   => 'sometimes|email|unique:users,el_pastas,' . $user->id,
            'slaptazodis' => 'sometimes|string|min:6',
            'telefonas'   => 'nullable|string|max:30',
            'adresas_id'  => 'sometimes|exists:adresas,id',
            'role'        => 'sometimes|string|in:admin,seller,buyer'
        ]);

        if (isset($data['slaptazodis'])) {
            $data['slaptazodis'] = bcrypt($data['slaptazodis']);
        }

        $user->update($data);
       return $this->sendResponse(new UserResource($user), 'Vartotojas atnaujintas.');
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->sendResponse(null, 'Vartotojas ištrintas.');
    }
}
