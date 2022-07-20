<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    //Función para mostrar los roles 
    public function index()
    {
        $role = Role::all();
        return response()->json([
            'status' => 'success',
            'rol' => $role,
        ]);
    }

    //Función para crear un rol
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return response()->json([
            'status' => 'success',
            'message' => 'El rol fue creado con éxito',
            'rol' => $role,
            ]);
    }

    //Función para actualizar un rol
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role= Role::find($id);
        $role->name = $request->name;
        $role->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Rol actualizado con éxito',
            'rol' => $role,
        ]);

    }

    //Función para eliminar un rol
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rol eliminado con exito',
            'rol' => $role,
        ]);
    }

    
    public function show($id)
    {
        $role = Role::find($id);
        return response()->json([
            'status' => 'success',
            'rol' => $role,
        ]);
    }

    public function existe(Request $request)
    {
        $role= Role::where('role',$request->role)->first();
        return response()->json([
            'status' => $role? 1:0, // 1 existe, 0 no existe
        ]);
    }
}
