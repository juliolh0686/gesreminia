<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        $user = User::with(['roles:id,name'])->where($criterio,'like','%'.$buscar.'%')
        ->paginate(10);

        return [
            'pagination' =>[
                'total'         => $user->total(),
                'current_page'  => $user->currentPage(),
                'per_page'      => $user->perpage(),
                'last_page'     => $user->lastPage(),
                'from'          => $user->firstItem(),
                'to'            => $user->lastItem(),
            ],
            'user' => $user
        ];
    }

    
    public function create()
    {
        return view('user.create');
    }

    
    public function store(Request $request)
    {
        $user = user::create($request->all());
        return redirect()->route('user.edit',$user->id)
                ->with('info','Producto guardado con exito');
    }

    
    public function show(user $user)
    {
        return view('users.show',compact('user'));
    }

    
    public function edit(user $user)
    {
        //$roles=Role::get();
        return view('users.edit',compact('user'));
    }

    
    public function update(Request $request, user $user)
    {
        //Actualize el usuario
            $user ->update($request->all());
        //actualize roles
           // $user->roles()->sync($request->get('roles'));

        return redirect()->route('users.edit',$user->id)
                ->with('info','Usuario actualizado con exito');
    }

    
    public function destroy(user $user)
    {
  
        $user->delete();

        return back()->with('info','Eliminado correctamente');
    }
}
