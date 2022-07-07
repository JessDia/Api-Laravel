<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     //------------------------- Funcion para listar los productos
    public function index()
    {
        $productos = Producto::all();
        return response()->json([
            'status' => 'success',
            'productos' => $productos,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //------------------------Función para crear un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:productos',
            'precio' =>'required|digits_between:3,5',
            'stock'=>'required|digits_between:1,3',
        ]);
        
        $productos = new Producto();
        $productos->nombre = $request->nombre;
        $productos->precio = $request->precio;
        $productos->stock = $request->stock;
        $productos->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Producto creado con exito',
            'Productos' => $productos,
            ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //------------------------ Funcion para filtrar producto por id
    public function show($id)
    {
        $productos= Producto::find($id);
        return response()->json([
            'status' => 'success',
            'productos' => $productos,
        ]);
    }

    //------------------------------------funcion para actualizar stock de productos
    public function stock(Request $request, $id)
    {
        $request->validate([
            'stock'=>'required',
        ]);
        $productos= Producto::find($id);
        $productos->stock = $request->stock;
        $productos->save();

        return response()->json([
            'status' => 'success',
            'message' => 'stock actualizado con exito',
            'productos' => $productos,
        ]);
        
    }

    //----------------Función para generar compra y modificar stock
    public function compra(Request $request, $id)
    {
        $request->validate([
            'cantidad'=>'required',
        ]);
        $productos= Producto::find($id);
        $productos->stock = $productos->stock-$request->cantidad;
        $productos->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Venta exitosa',
            'productos' => $productos,
        ]);
        
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //------------------Función para actualizar productos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' =>'required|digits_between:3,5',
            'stock'=>'required|digits_between:1,3',
        ]);
        $productos= Producto::find($id);
        $productos->nombre = $request->nombre;
        $productos->precio = $request->precio;
        $productos->stock = $request->stock;
        $productos->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Producto actualizado con exito',
            'productos' => $productos,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //---------------------------------Funcion para eliminar producto
    public function destroy($id)
    {
        $productos = Producto::find($id);
        $productos->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Producto eliminado con exito',
            'productos' => $productos,
        ]);
    }
}
