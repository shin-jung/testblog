<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Services\AuthService;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	protected $authService;

	public function __construct(AuthService $authService)
	{
		$this->authService = $authService;
	}

    public function login(Request $request)
    {
    	$input = $request->only('email', 'password');
    	$token = null;

    	if(!$token = JWTAuth::attempt($input)) {
    		return response()->json([
    			'success' => false,
    			'message' => 'Invalid Email or Password.',
    			'data' => '',
    		], 401);
    	}
    	return response()->json([
    		'success' => true,
    		'message' => 'Success, you can login.',
    		'data' => $token,
    	], 200);
    }

    public function register(Request $request)
    {
    	if($this->authService->register($request)) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Success.',
    			'date' => '',
    		], 200);
    	} else {
    		return response()->json([
    			'success' => false,
    			'message' => 'Sorry.',
    			'date' => '',
    		], 422);
    	}
    }
}
