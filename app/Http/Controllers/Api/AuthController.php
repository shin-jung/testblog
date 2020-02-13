<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Services\Api\AuthService;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    	if (!$token = JWTAuth::attempt($input)) {
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:20',
            'email' => 'required|string|email|max:40|unique:users',
            'password' => 'required|string|min:6|max:20|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, you have some validate error.',
                'data' => '',
            ], 401);
        }
        if ($this->authService->register($request)) {
            return response()->json([
                'success' => true,
                'message' => 'Success.',
                'data' => '',
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully.',
                'data' => '',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out.',
                'data' => '',
            ], 500);
        }
    }
}