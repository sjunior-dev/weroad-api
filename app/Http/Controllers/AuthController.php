<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            /** @var \App\Models\User $user */
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json(['data' => new LoginResource($user)], 200);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->apiToken = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }
}
