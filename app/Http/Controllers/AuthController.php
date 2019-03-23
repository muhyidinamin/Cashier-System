<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(Request $request){
        // $this->validate($request, [
        //     'name' => 'required',
        //     'category' => 'required',
        //     'price' => 'required',
        //     'status' => 'required'
        // ]);

        // $name = $request->input('name');
        // $category = $request->input('category');
        // $price = $request->input('price');
        // $status = $request->input('status');
    }

    public function login(Request $request){
        return "It's work";
    }
}
