<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak dapat mengubah data akun sendiri');
        }
        
        $validatedData = $request->validated();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if (isset($validatedData['role'])) {
            if (Auth::user()->role !== 'superadmin') {
                return back()->with('error', 'Anda tidak memiliki izin mengubah role');
            }
        }
        $user->update($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }
}
