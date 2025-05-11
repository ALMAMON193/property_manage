<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        // Validate login credentials
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $credentials = $request->only('email', 'password');

            // Attempt to login and generate token
            if (!$token = auth('api')->attempt($credentials)) {
                return $this->sendError('Unauthorized', ['error' => 'Invalid email or password'], 401);
            }

            $user = auth('api')->user();

            $success = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country' => $user->country,
                'user_type' => $user->user_type,
            ];

            return $this->sendResponse($success, 'Login successful', $token);

        } catch (\Exception $e) {
            \Log::error('Login error', ['error' => $e->getMessage()]);
            return $this->sendError('Something went wrong during login', ['error' => $e->getMessage()], 500);
        }
    }


    public function userStore(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'password' => Hash::make($request->password),
                'user_type' => 'user',
            ]);

            // Generate JWT token
            $token = auth('api')->login($user);

            // Prepare response data
            $success = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country' => $user->country,
                'user_type' => $user->user_type,
            ];

            return $this->sendResponse($success, 'User registered and logged in successfully', $token);

        } catch (\Exception $e) {
            \Log::error('Registration error', ['error' => $e->getMessage()]);
            return $this->sendError('Something went wrong during registration', ['error' => $e->getMessage()], 500);
        }
    }


    public function getProfile()
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->sendError('Unauthorized', ['error' => 'User not found or token invalid'], 401);
            }

            $profile = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country' => $user->country,
                'user_type' => $user->user_type,
            ];

            return $this->sendResponse($profile, 'User profile retrieved successfully');

        } catch (\Exception $e) {
            \Log::error('Get Profile Error', ['error' => $e->getMessage()]);
            return $this->sendError('Something went wrong while fetching profile', ['error' => $e->getMessage()], 500);
        }
    }


    public function logout()
    {
        try {
            // Invalidate the token
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->sendResponse([], 'User logged out successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to log out, please try again.' . $e->getMessage(), [], 400);
        }
    }
}
