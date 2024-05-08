<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $auth_id = Auth::user()->id;
        $rentlog = RentLogs::with(['user', 'book'])->where('user_id', $auth_id)->get();
        return view('profile', ['rentlog' => $rentlog]);
    }

    public function index()
    {
        $users = User::where(['status' => 'active', 'role_id' => 2])->get();
        $deleteUser = User::onlyTrashed()->get();
        return view('user', ['users' => $users, 'deleteUser' => $deleteUser]);
    }

    public function registered()
    {
        $registeredUser = User::where(['status' => 'inactive', 'role_id' => 2])->get();
        return view('registered-user', ['registeredUser' => $registeredUser]);
    }

    public function edit()
    {
        $auth = Auth::user();
        return view('edit-user', ['auth' => $auth]);
    }

    public function update(Request $request)
    {
        // Get current user
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);

        // Update user to database
        $userData = $request->all();

        // Check if a new password is provided
        if ($request->password) {
            // If a new password is provided, update with the new password
            $userData['password'] = $request->password;
        } else {
            // If no new password is provided, keep the old password
            $userData['password'] = $user->password;
        }

        $user->update($userData);
        // Redirect to route
        return redirect('profile-edit')->with(['success' => 'Updated User successfully']);
    }

    public function show($slug)
    {
        $detailUser = User::where('slug', $slug)->first();
        $rentlog = RentLogs::with(['user', 'book'])->where('user_id', $detailUser->id)->get();
        return view('detail-user', ['detailUser' => $detailUser, 'rentlog' => $rentlog]);
    }

    public function approve($slug)
    {
        $user = User::where('slug', $slug)->first();
        $user->status = 'active';
        $user->save();

        return redirect('detail-user/' . $slug)->with(['success' => 'Approve user successfully']);
    }

    public function unapprove($slug)
    {
        $user = User::where('slug', $slug)->first();
        $user->status = 'inactive';
        $user->save();

        return redirect('detail-user/' . $slug)->with(['success' => 'Unapprove user successfully']);
    }

    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->first();


        // Hapus semua log sewa yang terkait dengan pengguna
        $user->rentLogs()->delete();

        // Hapus pengguna
        $user->delete();
        return redirect('users')->with(['success' => 'Ban user successfully']);
    }

    public function restore($slug)
    {
        $restore = User::withTrashed()->where('slug', $slug)->first();
        $restore->rentLogs()->restore();
        $restore->restore();

        return redirect('users')->with(['success' => 'Restore user successfully']);
    }
}
