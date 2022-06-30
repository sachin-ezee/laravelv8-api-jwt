<?php

namespace App\Http\Controllers;


use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
/**
 * @group User Managment
 * 
 * Apis Manage User login, Register and Authenticate
 */


class ApiController extends Controller
{
    /**
     * Register User
     * 
     * Register New User
     * 
     *   
     */
    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'error' => false,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    /**
     * Login User
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'error' => true,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'error' => true,
                	'message' => 'Could not create token.',
                ], 500);
        }
 	
 		//Token created, return with success response and jwt token
        return response()->json([
            'error' => false,
            'message' => 'Token Generated and Login Success',
            'token' => $token,
        ]);
    }
 
    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'error' => false,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'error' => true,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    /**
     * Get Login User Details using token
     * 
     * @bodyParam token string required for get response
     */
    public function get_user(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->messages()], 200);
        }
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['error' => false, 'message' => 'User Detail fetch','user' => $user]);
    }
}