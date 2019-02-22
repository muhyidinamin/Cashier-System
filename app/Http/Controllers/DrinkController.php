<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $drinks = \App\Drink::paginate(10);

        $filterKeyword = $request->get('drink_name');
        if($filterKeyword){
            $drinks = \App\Drink::where("drink_name", "LIKE", "%$filterKeyword%")->paginate(10);
        }
        return view('drinks.index', ['drinks' => $drinks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drinks.create');
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

        $new_drink = new \App\Drink;
        $new_drink->drink_name = $name;
        $new_drink->price = $price;
        $new_drink->status = $status;
        $new_drink->created_by = \Auth::user()->id;
        $new_drink->save();
        return redirect()->route('drinks.create')->with('status', 'Drink successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drink = \App\Drink::findOrFail($id);
        return view('drinks.show', ['drink' => $drink]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drink_to_edit = \App\Drink::findOrFail($id);
        return view('drinks.edit', ['drink' => $drink_to_edit]);
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

        $drink = \App\Drink::findOrFail($id);

        $drink->name = $name;
        $drink->slug = $slug;

        $drink->updated_by = \Auth::user()->id;
        $drink->slug = str_slug($name);

        $drink->save();
        return redirect()->route('drinks.edit', ['id' => $id])->with('status', 'Drink succesfully update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drink = \App\Drink::findOrFail($id);
        $drink->delete();
        return redirect()->route('drinks.index')->with('status', 'Drink successfully moved to trash');
    }

        public function trash(){
        $deleted_drink = \App\Drink::onlyTrashed()->paginate(10);
        return view('drinks.trash', ['drinks' => $deleted_drink]);
    }

    public function restore($id){
        $drink = \App\Drink::withTrashed()->findOrFail($id);
        if($drink->trashed()){
            $drink->restore();
        } else {
            return redirect()->route('drinks.index')
                ->with('status', 'Drink is not in trash');
        }
        return redirect()->route('drinks.index')
            ->with('status', 'Drink successfully restored');
    }

    public function deletePermanent($id){
        $drink = \App\Drink::withTrashed()->findOrFail($id);
        if(!$drink->trashed()){
            return redirect()->route('drinks.index')
                ->with('status', 'Can not delete permanent active drink');
        } else {
            $drink->forceDelete();
            return redirect()->route('drinks.index')
                ->with('status', 'Drink permanently deleted');
        }
    }
}
