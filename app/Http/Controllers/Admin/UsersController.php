<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function showAllUsers()
    {
        $users = User::query()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
