<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $foods = \App\Food::paginate(10);

        $filterKeyword = $request->get('food_name');
        if($filterKeyword){
            $foods = \App\Food::where("food_name", "LIKE", "%$filterKeyword%")->paginate(10);
        }
        return view('foods.index', ['foods' => $foods]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('foods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $price = $request->get('price');
        $status = $request->get('status');
        $category = $request->get('categories');

        $new_food = new \App\Food;
        $new_food->food_name = $name;
        $new_food->price = $price;
        $new_food->status = $status;
        $new_food->category = $category;
        $new_food->created_by = \Auth::user()->id;
        $new_food->save();

        return redirect()->route('foods.create')->with('status', 'Food successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = \App\Food::findOrFail($id);
        return view('foods.show', ['food' => $food]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $food_to_edit = \App\Food::findOrFail($id);
        return view('foods.edit', ['food' => $food_to_edit]);
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
        $name = $request->get('name');
        $price = $request->get('price');
        $status = $request->get('status');

        $food = \App\Food::findOrFail($id);

        $food->name = $name;
        $food->slug = $slug;

        $food->updated_by = \Auth::user()->id;
        $food->slug = str_slug($name);

        $food->save();
        return redirect()->route('foods.edit', ['id' => $id])->with('status', 'Food succesfully update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = \App\Food::findOrFail($id);
        $food->delete();
        return redirect()->route('foods.index')->with('status', 'Food successfully moved to trash');
    }

    public function trash(){
        $deleted_food = \App\Food::onlyTrashed()->paginate(10);
        return view('foods.trash', ['foods' => $deleted_food]);
    }

    public function restore($id){
        $food = \App\Food::withTrashed()->findOrFail($id);
        if($food->trashed()){
            $food->restore();
        } else {
            return redirect()->route('foods.index')
                ->with('status', 'Food is not in trash');
        }
        return redirect()->route('foods.index')
            ->with('status', 'Food successfully restored');
    }

    public function deletePermanent($id){
        $food = \App\Food::withTrashed()->findOrFail($id);
        if(!$food->trashed()){
            return redirect()->route('foods.index')
                ->with('status', 'Can not delete permanent active food');
        } else {
            $food->forceDelete();
            return redirect()->route('foods.index')
                ->with('status', 'Food permanently deleted');
        }
    }
}
