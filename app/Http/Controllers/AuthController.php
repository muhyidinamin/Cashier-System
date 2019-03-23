<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $status = $request->input('status');

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'status' => $status
        ]);

        if ($user->save()){
            $user->login = [
                'href' => 'api/v1/user/login',
                'method' => 'POST', 
                'params' => 'email, password'
            ];
            $response = [
                'msg' => 'User created', 
                'user' => $user
            ];
            return response()->json($response, 201);
        }

        return response()->json($response, 404);
    }

    public function login(Request $request){
        return "It's work";
    }
}
