<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::isNotMe()->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function settings()
    {
        return view('settings');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(auth()->id());
        $user->name = $request->name;
        $user->password = $request->password == '' ? $user->password : Hash::make($request->password);
        $user->save();
        flash('Your account has been updated')->success();
        return redirect()->route('home');
    }

    public function destroy(User $user)
    {
        $user->delete();
        flash('Úser deleted')->success();

        return redirect()->back();
    }
}
