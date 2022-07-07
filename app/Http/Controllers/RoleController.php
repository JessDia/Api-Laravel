<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //------------------Función para mostrar los roles 
    public function index()
    {
        $role = Role::all();
        return response()->json([
            'status' => 'success',
            'productos' => $role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //-------------------Función para crear un rol
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
            'Productos' => $role,
            ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //------------Función para actualizar un rol
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
            'productos' => $role,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //----------Función para eliminar un rol
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rol eliminado con exito',
            'productos' => $role,
        ]);
    }
}
