<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use URL;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin.users.role.list', compact('roles'));
    }

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
        $role = Role::findOrFail($id);

        if (Auth::user()->hasRole('grant admin') == false && $role->hasPermissionTo('edit rolesAndPermissions')) {
            return redirect()->route('admin.roles.index')->with('status', 'У вас нет доступа для изменения этой роли.');
        }

        if (Auth::user()->hasRole('grant admin')) {
            $permissions = Permission::all();
        } else {
            $permissions = Permission::where([
                ['name', '!=', 'edit rolesAndPermissions']
            ])->get();
        }

        return view('admin.users.role.edit', compact('role', 'permissions'));
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
        $role = Role::findOrFail($id);

        if (strpos(URL::previous(), $id) === false) {
            return redirect()->back()->with('status', 'Была предпринята попытка назначить права другой роли в обход. Не делайте так пожалуйста.');
        }

        $permissions = array_slice($request->all(), 2);
        $role->revokePermissionTo(Permission::all());

        foreach ($permissions as $permission => $bool) {
            $permission = str_replace("_", " ", $permission);
            $role->givePermissionTo($permission);
        }

        return redirect()->back()->with('success', 'Права доступа для роли [' . $role->name . '] были успешно заменены.');
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
