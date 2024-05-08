<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserDetailResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
        // return response()->json(['data' => $user]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return response()->json([
            'message' => 'Restore User Successfully',
            'data' => $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return new UserDetailResource($user);
        // return response()->json($user);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => "Banned User Successfully",
            'data' => $user,
        ]);
    }

    public function banned()
    {
        $banUser = User::onlyTrashed()->get();

        return response()->json([
            'message' => 'Banned User',
            'data' => $banUser,
        ]);
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return response()->json([
            'message' => 'Approved User Successfully',
            'data' => new UserDetailResource($user),

        ]);
    }

    public function unapprove($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();

        return response()->json([
            'message' => 'UnApproved User Successfully',
            'data' => new UserDetailResource($user),

        ]);
    }
}
