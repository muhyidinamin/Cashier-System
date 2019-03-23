<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Food::all();
        foreach($menus as $menu){
            $menu->view_food = [
                'href'=> 'api/v1/menu/'.$menu->id, 
                'method' => 'GET'
            ];
        }
        $respone = [
            'msg'=>'List all Food',
            'menus'=> $menus
        ];

        return response()->json($respone, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);

        $name = $request->input('name');
        $category = $request->input('category');
        $price = $request->input('price');
        $status = $request->input('status');

        $menu = [
            'name' => $name, 
            'category' => $category, 
            'price' => $price, 
            'status' => $status, 
            'view_menu' => [
                'href' => 'api/v1/menu/1',
                'method'=> 'GET' 
            ]
        ];

        $respone = [
            'msg' => 'Menu Created',
            'data' => $menu
        ];

        return response()->json($respone, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "It's work";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return "It's work";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "It's work";
    }
}
