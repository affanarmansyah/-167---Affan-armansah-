<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserDetailResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;

        return response()->json($user);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:250|unique:users',
            'password' => 'required|min:6|max:250',
            'phone' => 'max:250',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "failed to create account",
                "errors" => $validator->errors()->all(),
            ], 404);
        }

        $user = User::create($request->all());

        return response()->json([
            "message" => "Register account successfully!",
            "data" => $user,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'success, You have been logged out',
        ]);
    }


    public function update(Request $request, string $id)
    {
        // $userId = Auth::user()->id;
        $user = User::findOrFail($id);

        // Update user to database
        $userData = $request->all();

        // Check if a new password is provided
        if ($request->password != null) {
            // If a new password is provided, update with the new password
            $userData['password'] = $request->password;
        } else {
            // If no new password is provided, keep the old password
            $userData['password'] = $user->password;
        }

        $user->update($userData);

        return response()->json([
            'message' => "Updated Successfully",
            'data' => new UserDetailResource($user),
        ]);
    }
}
