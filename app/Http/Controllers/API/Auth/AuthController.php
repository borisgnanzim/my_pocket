<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController handles user authentication and registration.
 *
 * @group Authentication
 * @authenticated
 */
class AuthController extends Controller
{
    use JsonResponseTrait;
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['user_name_or_email'])
            ->orWhere('user_name', $credentials['user_name_or_email'])
            // ->where('is_active', true) // Ensure the user is active
        ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = Cookie::forget('auth_token');

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'Logged in successfully')->withCookie($cookie);
    }

     public function logout(Request $request)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!$request->user()) {
            return $this->errorResponse('Unauthorized', 401);
        }
        // Vérifie si l'utilisateur a un token actif
        if (!$request->user()->currentAccessToken()) {
            return $this->errorResponse('No active token found', 401);
        }
        // supprime tous les tokens de l'utilisateur
        $request->user()->tokens()->delete();
        
        //$request->user()->currentAccessToken()->delete();

        $cookie = Cookie::forget('auth_token');

        return $this->successResponse('', 'Logged out successfully')->withCookie($cookie);
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'user_name' => $validatedData['user_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            //'phone_number' => $validatedData['phone_number'],
            'is_active' => true,
        ]);

        
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('auth_token', $token, 1440, null, null, false, true);


        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'Client Registered successfully', 201)->cookie($cookie);
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        return $this->successResponse(new UserResource($user));
    }
}
