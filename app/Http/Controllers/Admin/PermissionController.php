<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if ($user->hasPermissionTo('edit rolesAndPermissions') && !Auth::user()->hasRole('grant admin')) {
            return redirect()->back()->with('status', 'Изменение прав этого пользователя может осуществить только великий админ.');
        }

        $permissions = Permission::where('name', '!=', 'edit rolesAndPermissions')->get();
        
        if (Auth::user()->hasRole('grant admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where([
                ['name', '!=', 'grant admin'],
                ['name', '!=', 'admin']
            ])->get();
        }


        return view('admin.users.permission.edit', compact('user', 'permissions', 'roles'));
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
        $data = $request->all();
        $user = User::findOrFail($id);
        $assignableRole = [];
        $assignablePermissions = [];

        foreach ($data as $key => $value) {
            if (stripos($key, 'r') !== false) {
                $assignableRole[] .= $data[$key];
            } else {
                $assignablePermissions[] .= $data[$key];
            }
        }

        $user->syncPermissions();

        foreach ($assignablePermissions as $key => $permission) {
            if (!$user->hasPermissionTo($permission)) {
                $user->givePermissionTo($permission);
            }
        }

        $user->syncRoles($assignableRole);

        return abort(200, 'Роли и разрешения были удачно заменены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
