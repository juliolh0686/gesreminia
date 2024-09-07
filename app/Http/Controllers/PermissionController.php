<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    public function index(Request $request)
    {
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        $permissions = Permission::where($criterio,'like','%'.$buscar.'%')
        ->paginate(10);

        return [
            'pagination' =>[
                'total'         => $permissions->total(),
                'current_page'  => $permissions->currentPage(),
                'per_page'      => $permissions->perpage(),
                'last_page'     => $permissions->lastPage(),
                'from'          => $permissions->firstItem(),
                'to'            => $permissions->lastItem(),
            ],
            'user' => $permissions
        ];
    }

    public function listPermissions() {

        $permission = Permission::get();
        return ['permission'=>$permission];

    }
    
    public function updatePermissions(Request $request)
    {
        $id= $request->id;
        $permissions = $request->permissions;

        $rol = Role::find($id);
        $rol->syncPermissions($permissions);
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
