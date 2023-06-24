<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $users = User::where('nama', 'like', '%' . $keyword . '%')->get();

        return view('search', compact('users'));
    }
}
