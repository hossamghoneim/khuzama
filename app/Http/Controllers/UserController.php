<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){

            $users = User::query()->with('roles');

            return DataTables::collection($users->get())

                ->editColumn('email_column', function ($user){

                    $column = $user->email ;

                    if($user->email_confirmed){

                        $column .= " | <span class='label label-success label-success'><i class='fa fa-check-circle'></i> Verified</span>";
                    }else{
                        $column .= " | <span class='label label-danger label-danger'><i class='fa fa-info-circle'></i>  not Verified</span>";
                    }

                    return $column;
                })
                ->editColumn('mobile_column', function ($user){

                    $column = $user->mobile;

                    if($user->mobile_confirmed){
                        $column .= " | <span class='label label-success label-success'><i class='fa fa-check-circle'></i> Verified</span>";
                    }else{
                        $column .= " | <span class='label label-danger label-danger'><i class='fa fa-info-circle'></i>  not Verified</span>";
                    }

                    return $column;

                })

                ->editColumn('created_at', function ($user){
                    return $user->created_at->format('Y-m-d').' | ' .$user->created_at->diffForHumans() ;
                })

                ->editColumn('options', function ($user){

                    $edit = route('users.edit',$user->id);
                    $buttons = '';
                    if($user->id === 1 || $user->id === auth()->id() || auth()->id() === 1) {

                        if($user->id  !== 1){
                        $buttons .= "<a class='btn btn-xs btn-primary' href='$edit'><i class='fa fa-edit'></i></a>";
                        }
                    }
                    if($user->id !== 1 && $user->id !== auth()->id()) {

                        $buttons .= "  |  <button data-id='$user->id' type='button' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>";
                    }
                    return $buttons;
                })

                ->rawColumns(['email_column','mobile_column','options'])

                ->make(true);
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::query()->pluck('name','id');

        return view('user.create', compact('roles'));
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

        $ids = implode(',',Role::where('guard_name','web')->pluck('id')->toArray());

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'role' => 'required|in:'.$ids,
            'username' => 'required|integer|min:1000|max:100000|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|digits:9|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $user =  User::create([
            'name' => $request->name,
	    'username' => $request->username,
           'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles(Role::findOrFail($request->role)->name);

        flash()->success('User Has Been Created!');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $roles = Role::where('guard_name','web')->pluck('name','id');

        return view('user.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //

        $ids = implode(',',Role::where('guard_name','web')->pluck('id')->toArray());

        //
        $this->validate($request, [

            'name' => 'required|max:255',
            'username' => 'required|max:255|integer|min:1000|max:100000',
            'role' => 'required|in:'.$ids,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'mobile' => 'required|digits:9|unique:users,mobile,'.$user->id,
            'password' => 'confirmed'
        ]);

        try{
            \DB::beginTransaction();

            $inputs = [];

            if( trim($request->input('name')) != $user->name){
                $inputs['name'] = trim($request->name);
            }
            if( $request->input('password') != ''){
                $inputs['password'] = bcrypt($request->password);
            }

            if( trim($request->input('email')) != $user->email){
                $inputs['email'] = trim($request->email);
                $inputs['email_confirmed'] = 0;
            }

            if( trim($request->input('mobile')) != $user->mobile){
                $inputs['mobile'] = trim($request->mobile);
                $inputs['mobile_confirmed'] = 0;
            }

            if(count($inputs)){
                $user->update($inputs);
            }

            if(!$user->roles->find($request->role)){

                $user->syncRoles(Role::findOrFail($request->role)->name);
            }

            \DB::commit();

        }catch(\Exception $e){

            \DB::rollback();
            return back();
        }

        flash('User Account has been updated','success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        if(\request()->ajax() && $user->id !== 1 ){

            return response()->json($user->delete(),200);
        }

        return abort(401);
    }
}
