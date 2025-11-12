<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return response()->json(User::all());
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
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
        
return response()->json($user, 201);
}

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
