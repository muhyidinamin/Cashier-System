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
        $response = [
            'msg'=>'List all Food',
            'menus'=> $menus
        ];

        return response()->json($response, 200);
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
            'status' => 'required',
            'user_id' => 'required'
        ]);

        $name = $request->input('name');
        $category = $request->input('category');
        $price = $request->input('price');
        $status = $request->input('status');
        $user_id = $request->input('user_id');
        $menu = new Food();

        /*$menu = new Food([
            'food_name' => $name, 
            'category' => $category, 
            'price' => $price, 
            'status' => $status,
            'created_by'=> $user_id
        ]); */

        $menu->food_name = $name;
        $menu->price = $price;
        $menu->status = $status;
        $menu->category = $category;
        $menu->created_by = $user_id; 

        if($menu->save()){
            //$menu->users()->attach($user_id);
            $menu->view_menu = [
                'href' => 'api/v1/menu/'.$menu->id,
                'method' => 'GET'
            ];
            $message = [
                'msg' => 'Food added',
                'menu' => $menu
            ];
            return response()->json($message, 201);
        }

        $response = [
            'msg' => 'Error during creation'
        ];

        return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Food::where('id', $id)->firstOrFail();
        $menu->view_menus = [
            'href' => 'api/v1/menu',
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Menu Information',
            'menu' => $menu
        ];
        return response()->json($response, 200);
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
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'status' => 'required',
            'user_id' => 'required'
        ]);

        $name = $request->input('name');
        $category = $request->input('category');
        $price = $request->input('price');
        $status = $request->input('status');
        $user_id = $request->input('user_id');

        $menu = Food::findOrFail($id);

        /* if(!$menu->users()->where('users.id', $user_id)->first()){
            return response()->json(['msg' => 'user not registered for menu, update not succesful'], 401);
        } */

        $menu->food_name = $name;
        $menu->category = $category;
        $menu->price = $price;
        $menu->status = $status;
        $menu->updated_by = $user_id;

        if(!$menu->update()){
            return response()->json([
                'msg' => 'Error during update'
            ],404);
        }

        $menu->view_menu = [
            'href' => 'api/v1/menu/'.$menu->id,
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Menu Updated',
            'menu' => $menu
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Food::findOrFail($id);

        if(!$menu->delete()){
            foreach ($users as $user){
                $menu->users()->attach($user);
            }
            return response()->json([
                'msg' => 'Deletion Failed'
            ], 404);
        }

        $response = [
            'msg' => 'Menu deleted',
            'create' => [
                'href' => 'api/v1/menu',
                'method' => 'POST',
                'params' => 'name, category, price, status'
            ]
        ];
        return response()->json($response, 200);
    }
}
