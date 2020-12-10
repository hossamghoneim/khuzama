<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws
     * @return object
     */
    public function index()
    {
        //
        if(\request()->ajax()){

            $components = Component::query();

            return DataTables::eloquent($components)
                ->editColumn('created_at', function ($component){
                    return $component->created_at->format('Y - m - d') . ' | ' . $component->created_at->diffForHumans();
                })


                ->editColumn('options', function ($component){

                    if(!in_array($component->id,[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16
                        ,17,18,19,20,21,22,23,24,25,26])){
                    $edit_link = route('components.edit',$component->id);
                    $buttons = '';


                    $buttons .= "<a href='$edit_link' class='btn btn-sm btn-success '><i class='fa fa-edit'></i></a>";
                    $buttons .= " | ";
                    $buttons .= "<button type='button' data-id='$component->id' class='btn btn-sm btn-danger  delete'><i class='fa fa-trash'></i></button>";

                    }else{
                        $buttons = "";
                    }

                    return $buttons;
                })
                ->rawColumns(['options'])
                ->make(true);
        }

        return view('components.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('components.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //
        $this->validate($request,[
            'allergen' => 'required|min:3|max:255|unique:components,allergen',
            'cas' => 'required|min:3|max:255|unique:components,cas',
        ]);

        $component = Component::create($request->except(['attachments']));

        flash('Component Has been Created!')->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function show(Component $component)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function edit(Component $component)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Component $component)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        //
        return response()->json($component->delete(),200);

    }
}
