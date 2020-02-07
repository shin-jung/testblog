<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\User;

class AuthRepository
{

	public function register(Request $request)
	{
		return User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
		]);
	}
}