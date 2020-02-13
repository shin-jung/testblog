<?php

namespace App\Repositories\Api;

use App\User;
use Illuminate\Http\Request;

class UserRepository
{
	public function showUserList()
	{
		return User::all();
	}

	public function register(Request $request)
	{
		return User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
		]);
	}
}