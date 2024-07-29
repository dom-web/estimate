<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     // 一覧表示
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }


    // 削除処理
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully.');
    }
}
