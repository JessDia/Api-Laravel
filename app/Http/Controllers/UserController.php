<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(){}
    
    //Función para listar toda la información de los usuarios
    public function index(){
        $user = User::with('roles')->get();
        return response()->json([
            'status' => 'success',
            'users' => $user,
        ]);
    }

    //Función para crear un nuevo usuario
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'roles' => 'required|int',
            'password' => 'required|digits_between:6,8',
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->syncRoles($request->roles);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'usuario creado con exito',
            'user' => $user,
        ]);
    }

    //Metodo para mostrar un usuario  especifico segun su ID
    public function show($id)
    {
        $user= User::with('roles')->find($id);
        return response()->json([
            'status' => 'success',
            'users' => $user,
        ]);
    }

    //Metodo para Actualizar  rol de un usuario
    public function updateRol(Request $request, $id){
        $request->validate([
        'rol' => 'required|string',
        ]);

        $rol = Role::where('name', $request->rol)->get();
        
        if (count($rol)==0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rol invalido',
            ]);
        }
        
        $user = User::find($id);
        $user->syncRoles($request->rol);
        $user->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Rol actualizado con exito',
            'user' => $user,
        ]);

    }

    //Metodo para actualizar datos del usuario
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'string',
            'lastname' => 'string',
            'email' => 'string|email|max:100',
            'roles' => 'int'
            //'password' => 'digits_between:6,8',
        ]);
        
        $user = User::find($id);
        $user->name = $request->name;
        $user->lastname= $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->syncRoles($request->roles);
        $user->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado con exito',
            'user' => $user,
        ]);
    }

    //Metodo para eliminar usuario 
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario eliminado con exito',
            'productos' => $user,
        ]);
    }


    //Validamos si el correo ya existe 
    public function existe(Request $request)
    {
        $user= User::where('email',$request->email)->first();
        return response()->json([
            'status' => $user? 1:0, // 1 existe, 0 no existe
        ]);
    }
    
}
