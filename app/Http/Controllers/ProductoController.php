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
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->middleware(['role:admin', 'permission:listar.productos|crear.productos|obtener.producto|
        // actualizar.producto|eliminar.producto']);
        // $this->middleware(['role:vendedor','permission:listar.productos|crear.productos|obtener.producto|
        // actualizar.producto|eliminar.producto']);
        
    }

    public function index()
    {
        //Listamos todos los productos
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
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' =>'required',
            'stock'=>'required',
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
    public function show($id)
    {
        $productos= Producto::find($id);
        return response()->json([
            'status' => 'success',
            'productos' => $productos,
        ]);
    }

    // public function edit(Request $request, $id){
    //     $productos = User::find($id);
    //     $productos->stock = $request->stock;
    //     $productos->save();
    //     return response()->json([
    //         'message' => 'Producto actualizado con exito',
    //         'productos' => $productos
    //     ]);
    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' =>'required',
            'stock'=>'required',
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
