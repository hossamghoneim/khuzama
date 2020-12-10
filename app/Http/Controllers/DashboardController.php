<?php

namespace App\Http\Controllers;


use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('home');
    }


    public function logs(){


        if(request()->ajax()){

            $activaties = Activity::all();

            return DataTables::of($activaties)


                ->editColumn('created_at', function ($user){
                    return $user->created_at->format('Y-m-d').' | ' .$user->created_at->diffForHumans() ;
                })

                ->editColumn('causer_id', function ($user){
                    return $user->causer_id ? $user->causer_id : 'system' ;
                })     ->editColumn('causer_type', function ($user){
                    return $user->causer_type ? $user->causer_type : 'system' ;
                })



                ->editColumn('options', function ($user){

                    /*$edit = route('users.edit',$user->id);
                    $buttons = '';

                            $buttons .= "<a class='btn btn-xs btn-primary' href='$edit'><i class='fa fa-edit'></i></a>";


                            $buttons .= "  |  <button data-id='$user->id' type='button' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>";

                    return $buttons;*/
                })

                ->rawColumns(['options'])

                ->make(true);
        }



        return view('logs.index', compact('activity'));
    }

}
