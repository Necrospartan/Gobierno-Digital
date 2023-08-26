<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        try{
            $rules = [
                'email' => 'required | email | max:191',
                'password' => 'required | string | max:191',
            ];
            $messages = [
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'email.max' => 'Email must be less than 191 characters',

                'password.required' => 'Password is required',
                'password.string' => 'Password must be a string',
                'password.max' => 'Password must be less than 191 characters',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()){
                return [
                    'validation' => 'failed',
                    'status' => false,
                    'error' => $validator->errors()
                ];
            }
            $credentials = [ 
                'email' => $request->input('email'), 
                'password' => $request->input('password')
            ];
            $token = JWTAuth::attempt($credentials);
            if(!$token){
                return response()->json([
                    'message' => 'Login failed',
                    'status' => false
                    ], 401);
            }
            $user = Auth::user();
            return response()->json([
                'message' => 'User authenticated',
                'token' => $token,
                'user' => $user
                ], 200);

        } catch(\Exception $e){
            return response()->json([
                'Exception' => 'Exception',
                'status' => false,
                'message' => $e->getMessage()
                ], 500);
        }
    }
    public function logout(Request $request)
    {
        $validator= Validator::make($request->only('token'), [
            'token' => 'required'
            ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Invalid token',
                'status' => false
            ], 401);
        }
        try{
            $token = $request->token;
            JWTAuth::invalidate($token);
            return response()->json([
                'message' => 'User disconnected',
                'status' => true
                ], 200);
        }catch(JWTException $e){
            return response()->json([
                'message' => 'Failed to disconnect',
                'status' => false,
                'error' => $e->getMessage()
                ], 500);
        }
    }
    public function getUser(Request $request)
    {
        try{
            $validator= Validator::make($request->all(), [
                'token' => 'required'
                ]);
            if($validator->fails()){
                return response()->json([
                    'message' => 'Invalid token',
                    'status' => false
                    ], 401);
            }
            $token = $request->token;
            $user = JWTAuth::authenticate($token);
            if(!$user){
                return response()->json([
                    'message' => 'Invalid token',
                    'status' => false
                    ], 401);
            }
            return response()->json([
                'user' => $user,
                'status' => true
                ], 200);
        } catch(\Exception $e){
            return response()->json([
                'Exception' => 'Exception',
                'status' => false,
                'message' => $e->getMessage()
                ], 500);
        }
    }
}
