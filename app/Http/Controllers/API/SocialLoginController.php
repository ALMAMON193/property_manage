<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialLoginController extends Controller
{
    use ResponseTrait;
    public function SocialLogin(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'provider' => 'required|in:google,apple',
        ]);

        try {
            $provider   = $request->provider;
            $socialUser = Socialite::driver($provider)->stateless()->userFromToken($request->token);


            if ($socialUser) {
                $user = User::where('email', $socialUser->email)
                    ->orWhere('provider_id', $socialUser->getId())
                    ->first();

                $isNewUser = false;

                if (!$user) {
                    $password = Str::random(8);
                    $user     = User::create([
                        'name'              => $socialUser->getName() ?? $socialUser->getNickname(),
                        'email'             => $socialUser->getEmail() ?? $socialUser->getId().'@'.$provider.'.com',
                        'password'          => bcrypt($password),
                        'provider'          => $provider,
                        'provider_id'       => $socialUser->getId(),
                        'user_type'              => 'user',
                        'email_verified_at' => now(),
                    ]);
                    $isNewUser = true;
                }

                // Generate token
                $token = auth('api')->login($user);

                // Prepare success response
                $success = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                ];

                // Evaluate the message based on the $isNewUser condition
                $message = $isNewUser ? 'User registered and logged in successfully' : 'User logged in successfully';


                return $this->sendResponse($success, $message, $token);

            } else {
                $error = 'Invalid credentials';
                $errorMessages = ['Invalid credentials'];
                $code = 404;
                return $this->sendError($error, $errorMessages, $code);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 401);
        }
    }






    public function updateProfile(Request $request)
    {
        // Validate the incoming request
        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^[0-9]{10,15}$/',
        ];
        $messages = [];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        $user = Auth::user();



        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return $this->sendResponse($user, 'User profile updated');
    }

    public function updateProfileImage(Request $request)
    {
        // Validate the incoming request
        $rules = [
            'image' => 'required|mimes:jpg,jpeg,png',
        ];
        $messages = [];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        $user = Auth::user();

        // Handle image upload
        $file = 'image';
        $imagePath = null;
        if ($request->hasFile($file)) {
            // Upload the new file
            $randomString = Str::random(10);
            $imagePath  = Helper::fileUpload($request->file($file), 'profile', $randomString);
        }

        $user->update([
            'image' => $imagePath
        ]);
        return $this->sendResponse($user, 'User profile image updated');
    }

    /**
     * Refresh the JWT token
     */
    public function refresh()
    {
        try {
            return $this->sendResponse([], 'Token refreshed successfully', auth()->refresh());
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->sendError('Token expired, please log in again', [], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->sendError('Invalid token', [], 401);
        } catch (\Exception $e) {
            return $this->sendError('Failed to refresh token: ' . $e->getMessage(), [], 400);
        }
    }
}
