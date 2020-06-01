<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Make an authentication attempt.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        /** @var array $credentials */
        $credentials = array_merge($request->only('email', 'password'), ['active' => true]);

        if (!Auth::attempt($credentials)) {
            return $this->response([], [__('auth.failed')], Response::HTTP_UNAUTHORIZED);
        }

        return $this->info();
    }

    /**
     * Get information of the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        /** @var UserResource $userResource */
        $userResource = new UserResource(Auth::user());

        return $this->response($userResource);
    }

    /**
     * Log the user out
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('web')->logout();

        return $this->response([__('auth.logout_message')]);
    }
}
