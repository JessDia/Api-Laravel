<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{

    //Funcion para listar los productos
    public function index()
    {
        $productos = Producto::all();
        return response()->json([
            'status' => 'success',
            'productos' => $productos,
        ]);
    }

    //Función para crear un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:productos',
            'precio' =>'required|min:3',
            'stock'=>'required|min:1',
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

    //Funcion para filtrar producto por id
    public function show($id)
    {
        $productos= Producto::find($id);
        return response()->json([
            'status' => 'success',
            'productos' => $productos,
        ]);
    }

    //Funcion para actualizar stock de productos
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

    //Función para generar compra y modificar stock
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

    //Función para actualizar productos
    public function update(Request $request, $id)
    {
        $productos = Producto::find($id);
        if(is_null($productos)){
            return reponse()->json([
                'message' => 'Producto no encontrado'
            ],404);
        }
        $productos -> update($request -> all());
        return response($productos,200);

    }

    //Funcion para eliminar producto
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

    //Se verifica si existe un producto con ese mismo nombre 
    public function existe(Request $request)
    {
        $producto= Producto::where('nombre',$request->nombre)->first();
        return response()->json([
            'status' => $producto? 1:0, // 1 existe, 0 no existe
        ]);
    }
}
