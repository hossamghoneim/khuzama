<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $roles = Role::query();

            $roles->withCount(['permissions']);

            $roles->addBinding(['select'=>'App\User'],'select');
            $roles->selectRaw('(select count(*) from users inner join model_has_roles on users.id = model_has_roles.model_id where roles.id = model_has_roles.role_id and model_has_roles.model_type = ?) as users_count');


            return DataTables::collection($roles->get())

                ->editColumn('users_count', function ($role){
                    return $role->users_count ;
                })

                ->editColumn('created_at', function ($role){
                    return $role->created_at->format('Y-m-d').' | ' .$role->created_at->diffForHumans() ;
                })

                ->editColumn('options', function ($role){

                    $edit = route('roles.edit',$role->id);
                    $buttons = '';
                    if(!in_array($role->id,[1])) {

                        $buttons .= "<a class='btn btn-xs btn-primary' href='$edit'><i class='fa fa-edit'></i></a>";
                    }
                    if(!in_array($role->id,[1])) {

                        $buttons .= "  |  <button data-id='$role->id' type='button' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button>";
                    }
                    return $buttons;
                })

                ->rawColumns(['options'])
                ->make(true);
        }

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('roles.create');
    }

    public function getGuardPermissions(){

        if(\request()->ajax()){

            $roles = Role::where('guard_name',\request()->guard_name)->first();

            $permissions = $roles->permissions->groupBy('group')->map(function ($item){
                return $item->pluck('name','id');
            });

            return response()->json(
                $permissions
                ,200);
        }

        return abort(401);

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
        $this->validate($request, [
            'name' => [
                Rule::unique('roles')->where(function ($query) use($request) {
                    return $query->where('guard_name','=', 'web');
                }),
            ],
            'role_permissions' => 'required'
            ,'role_permissions.*' => 'exists:permissions,id',
        ]);

        $selected_permissions = Permission::where('guard_name','web')
            ->whereIn('id',$request->role_permissions)
            ->pluck('name')->toArray();


        $role = Role::create([
            'name'=> $request->name,
            'guard_name' => 'web'
        ]);

        $role->givePermissionTo($selected_permissions);

        flash()->success('Role Has Been Created!');

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        $expects  = $role->permissions->pluck('id')->toArray();

        $all_permissions  = Permission::all()->where('guard_name','web')
            ->groupBy('group')->map(function ($item) {
            return $item->pluck('name', 'id');
        });

        return view('roles.edit', compact('role','all_permissions','expects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $this->validate($request, [
            'name' => [
                Rule::unique('roles')->where(function ($query) use($role) {
                    return $query->where('guard_name','=', 'web');
                })->ignore($role->id),
            ],
            'role_permissions' => 'required',
            'role_permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name'=> $request->name,
        ]);

        $selected_permissons = Permission::where('guard_name','web')
            ->whereIn('id',$request->role_permissions)
            ->pluck('name')->toArray();


        $role->syncPermissions($selected_permissons);

        flash()->success('Role Has Been Updated!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role->users->count() ? abort(500) : $role->delete();

    }
}
