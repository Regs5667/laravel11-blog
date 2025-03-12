<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('phone')->paginate(4);
        return view('user', ['data' => $users]);
    }
}
