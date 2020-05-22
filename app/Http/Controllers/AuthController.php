<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @group User Authentication
 *
 * APIs for users authentication
 */

class AuthController extends Controller
{
    /**
     * SignUp User
     *
     * sign up user in the application.
     *
     * @bodyParam name  string required The name of the user. Example: John Doe
     * @bodyParam email string required The email address of the user. Example: john.doe@example.com
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     *
     * @response {
     *   "message": 'Successfully created user!'
     * }
     */
    public function signup(Request $request) {
        $validators = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if ($validators->fails()) {
            return response()->json([
                'errors' => $validators->errors(),
        ], 400);
        }
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);

    }

    /**
     * Login
     *
     * login use and create token
     *
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam remember_me boolean
     *
     * @response {
     *  "access_token": "sdg46d4g",
     *  "token_type": "Bearer",
     *  "expires_at": ""
     * }
     */

    public function login(Request $request) {
        $validators = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validators->fails()) {
            return response()->json([
                'errors' => $validators->errors(),
        ], 400);
        }
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(4);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ]);
    }

    /**
     * Logout use
     * 
     * @return [string] message
     */

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out.'
        ]);
    }
}
