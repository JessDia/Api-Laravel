<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
        
    }
    
    //-------------------------Metodo para listar toda la información de los usuarios
    public function index(){
        $user = User::all();
        return response()->json([
            'status' => 'success',
            'users' => $user,
        ]);
    }

    //-----------------------------------------metodo para crear un nuevo usuario
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|digits_between:6,8',
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'usuario creado con exito',
            'user' => $user,
        ]);

    }

    //-------------------Metodo para mostrar un usuario  especifico segun su ID
    public function show($id)
    {
        $user= User::find($id);
        return response()->json([
            'status' => 'success',
            'productos' => $user,
        ]);
    }

    //---------------------------------------------------Metodo para Actualizar  rol de un usuario
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

    //---------------------------------------Metodo para actualizar datos del usuario
    public function update(Request $request, $id){
        $request->validate([
        'name' => 'string',
        'email' => 'string|email|max:100',
        'password' => 'digits_between:6,8',
        ]);

    $user = User::find($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();

    return response()->json([
    'status' => 'success',
    'message' => 'Usuario actualizado con exito',
    'user' => $user,
    ]);
        
    }

    //--------------------------------------------metodo para eliminar usuario 
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
    
}
