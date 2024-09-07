<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;


class RoleController extends Controller
{

    public function userRole(){

        $roles = Role::get();
        return ['roles'=>$roles];

    }
    
    public function index(Request $request)
    {

        $buscar= $request->buscar;

        $roles = Role::with('permissions')->where('name','like','%'.$buscar.'%')->paginate(10);

        return [
            'pagination' =>[
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perpage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      //*Guardar Datos en la tabla
      $role= new Role();
      $role->name = $request->name;
      $role->save();
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
      $rol= Role::findOrFail($request->id);
      $rol->name = $request->name;
      $rol->save();
    }

    public function updateRoles(Request $request)
    {
        $id= $request->id;
        $roles = $request->roles;

        $user = User::find($id);
        $user->syncRoles($roles);
    }

    public function destroy(Request $request)
    {
      $rol= Role::find($request->id);
      $rol->delete();
    }
}
