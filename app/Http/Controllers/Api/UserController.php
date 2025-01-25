<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows('viewAny', User::class)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $users = User::where('role', '!=', 'admin')->get();
        return response()->json(['users' => $users], 200);
    }
 
    
    public function show(User $user)    {
        
        if (!$user || !Gate::allows('view', $user)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }
        return response()->json(['user' => $user], 200);
    }
 
    
    public function store(Request $request)
    {
        if (!Gate::allows('create', User::class)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['admin', 'manager', 'user'])],
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
 
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
 
    
    public function update(Request $request, User $user)
    {
        if (!$user || !Gate::allows('update', $user)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }
 
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|required|string|min:6',
            'role' => ['sometimes', Rule::in(['admin', 'manager', 'user'])],
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
        ]);
 
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
     }
 
    
    public function destroy(User $user)
    {
        if (!$user || !Gate::allows('delete', $user)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }
 
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
     }
}
