<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'required|string|max:11',
        'role' => 'required|in:admin,customer',
    ]);

    $user = new User();
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->mobile = $request->mobile;
    $user->role = $request->role;
    $user->password = Hash::make('password');
    $user->email_verified_at = now();
    $user->save();

    return response()->json(['success' => true, 'message' => 'User added successfully.']);
}
    public function show($id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
        'mobile' => 'required|string',
        // 'role' => 'required|in:admin,staff,customer',
    ]);

    $user->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'User updated successfully',
        'user' => $user
    ]);
}
public function updateRole(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'role' => 'required|in:admin,customer',
    ]);

    $user->role = $validated['role'];
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'User role updated successfully',
        'user' => $user
    ]);
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'User deleted successfully'
    ]);
}
}
