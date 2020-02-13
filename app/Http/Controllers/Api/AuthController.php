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
    			'message' => '抱歉，信箱或密碼輸入錯誤。',
    			'data' => '',
    		], 401);
    	}
    	return response()->json([
    		'success' => true,
    		'message' => '成功，你已登入。',
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
                'message' => '抱歉，輸入格式有誤。',
                'data' => '',
            ], 401);
        }
        if ($this->authService->register($request)) {
            return response()->json([
                'success' => true,
                'message' => '成功，你已註冊。',
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
                'message' => '成功，你已登出。',
                'data' => '',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => '抱歉，你登出失敗。',
                'data' => '',
            ], 500);
        }
    }
}