<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FoodController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-foods')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $foods = \App\Food::leftJoin('categories', 'foods.category', '=', 'categories.id')
                ->select('categories.id as cat', 'categories.name', 'foods.*')->paginate(10);

        $filterKeyword = $request->get('keyword');
        
        $status = $request->get('status');
        if($status){
            $foods = \App\Food::leftJoin('categories', 'foods.category', '=', 'categories.id')
            ->select('categories.id as cat', 'categories.name', 'foods.*')
            ->where('status', $status)->paginate(10);
        } else {
            $foods = \App\Food::leftJoin('categories', 'foods.category', '=', 'categories.id')
            ->select('categories.id as cat', 'categories.name', 'foods.*')->paginate(10);
        }

        if($filterKeyword){
            if($status){
                $foods = \App\Food::leftJoin('categories', 'foods.category', '=', 'categories.id')
                        ->select('categories.id as cat', 'categories.name', 'foods.*')
                        ->where('status', $status)
                        ->where("food_name", "LIKE", "%$filterKeyword%")->paginate(10);
            } else {
                $foods = \App\Food::leftJoin('categories', 'foods.category', '=', 'categories.id')
                        ->select('categories.id as cat', 'categories.name', 'foods.*')
                        ->where("food_name", "LIKE", "%$filterKeyword%")->paginate(10);
                }
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
        \Validator::make($request->all(), [
            "name" => "required|min:5|max:200",
            "categories" => "required",
            "status" => "required",
            "price" => "required|digits_between:0,10"
        ])->validate();

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
        $food = \App\Food::leftJoin('categories', 'foods.category', '=', 'categories.id')
        ->select('categories.id as cat', 'categories.name', 'foods.*')
        ->findOrFail($id);
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
        \Validator::make($request->all(), [
            "name" => "required|min:5|max:200",
            "categories" => "required",
            "status" => "required",
            "price" => "required|digits_between:0,10"
        ])->validate();

        $name = $request->get('name');
        $price = $request->get('price');
        $status = $request->get('status');
        $category = $request->get('categories');

        $food = \App\Food::findOrFail($id);

        $food->food_name = $name;
        $food->price = $price;
        $food->status = $status;
        $food->category = $category;

        $food->updated_by = \Auth::user()->id;
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
        $deleted_food = \App\Food::onlyTrashed()->leftJoin('categories', 'foods.category', '=', 'categories.id')
        ->select('categories.id as cat', 'categories.name', 'foods.*')->paginate(10);
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
