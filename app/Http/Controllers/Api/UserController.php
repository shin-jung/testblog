<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\UserService;
use JWTAuth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	public function userList()
	{
		
		$showUser = $this->userService->userList(); 

		if ($showUser) {
			return response()->json([
				'success' => true,
				'message' => '成功，你可以看會員列表。',
				'data' => $showUser,
			], 200);
		}
	}
}
