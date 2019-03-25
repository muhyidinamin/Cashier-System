<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class AuthController extends Controller
{
    public function store(Request $request){
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        //     'status' => 'required'
        // ]);

        // $name = $request->input('name');
        // $email = $request->input('email');
        // $password = $request->input('password');
        // $status = $request->input('status');

        // $user = new User([
        //     'name' => $name,
        //     'email' => $email,
        //     'password' => $password,
        //     'status' => $status
        // ]);

        // if ($user->save()){
        //     $user->login = [
        //         'href' => 'api/v1/user/login',
        //         'method' => 'POST', 
        //         'params' => 'email, password'
        //     ];
        //     $response = [
        //         'msg' => 'User created', 
        //         'user' => $user
        //     ];
        //     return response()->json($response, 201);
        // }

        // return response()->json($response, 404);
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        if($user = \App\User::where('email', $email)->first()){
            $credentials = [
                'email' => $email,
                'password' => $password
            ];

            $token = null;
            try{
                if(!$token = JWTAuth::attempt($credentials)){
                    return response()->json([
                        'msg' => 'Email or Password are incorrect',
                    ], 404);
                }
            }catch(JWTException $e){
                return response()->json([
                    'msg' => 'failed_to_create_token',
                ], 404);
            }

            $response = [
                'msg' => 'User signin',
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An error occured'
        ];

        return response()->json($response, 404);
    }
}
