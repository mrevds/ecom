<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService  $userService
    ){}
    public function registerCustomer(Request $request)
    {
        $user = $this->userService->registerCustomer(
            $request->input('username'),
            $request->input('password')
        );
        return response()->json($user);
    }
    public function registerSeller(Request $request)
    {
        $user = $this->userService->registerSeller(
            $request->input('username'),
            $request->input('password')
        );
        return response()->json($user);
    }
    public function login(Request $request)
    {
        $user = $this->userService->login(
            $request->input('username'),
            $request->input('password')
        );
        $token = $user->createToken('auth_Token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
