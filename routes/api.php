<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// --------------------------------------- Autenticación ----------------------------------------
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function($route){
    Route::post('login', [AuthController::class,'login']); 
    Route::post('logout',[AuthController::class,'logout']); 
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::get('me',[AuthController::class,'me']);
    Route::post('register',[AuthController::class,'register']); 
    Route::post('email/existe',[AuthController::class,'existe']);
});


// --------------------------------------- CRUD de roles ----------------------------------------
Route::group(['middleware' => ['auth:api', 'is_admin']], function(){
    Route::get('role', [RoleController::class, 'index']); //--Mostrar 
    Route::get('show/role/{id}',[RoleController::class,'show']);
    Route::post('role',[RoleController::class,'store']); //--Crear 
    Route::put('role/{id}',[RoleController::class,'update']); // -- Actualizar 
    Route::delete('role/{id}',[RoleController::class,'destroy']); //--Eliminar 
    Route::post('role/existe',[RoleController::class,'existe']); 
});


// --------------------------------------- CRUD de usuarios ----------------------------------------
Route::group(['middleware' => ['auth:api','is_admin']],function(){
    Route::get('User/get',[UserController::class,'index']); //--Mostrar 
    Route::post('User/create',[UserController::class,'store']); //Crear 
    Route::get('User/show/{id}',[UserController::class,'show']); //Obtener por id 
    //Route::put('update/{id}',[UserController::class,'updateRol']); //Actualizar rol de usuario 
    Route::put('User/update/{id}',[UserController::class,'update']); //actualizar datos usuario 
    Route::delete('User/delete/{id}',[UserController::class,'destroy']); //Eliminar 
    Route::post('User/existe',[UserController::class,'existe']); //validar correo
});



// --------------------------------------- CRUD de productos ----------------------------------------
Route::group(['middleware' => ['auth:api']], function(){
Route::get('productos',[ProductoController::class,'index']); //Mostrar 
Route::post('addProductos',[ProductoController::class,'store'])->middleware(['is_autorizado']); //Crear 
Route::get('productosByID/{id}',[ProductoController::class,'show']);//Mostrar producto por id 
Route::put('updateProductos/{id}',[ProductoController::class,'update'])->middleware(['is_autorizado']); //actualizar  
Route::delete('deleteProductos/{id}',[ProductoController::class,'destroy'])->middleware(['is_autorizado']); //eliminar  
Route::put('comprar/{id}',[ProductoController::class,'compra']); //------------Comprar
//Route::put('actualizar/stock/{id}',[ProductoController::class,'stock'])->middleware(['is_autorizado']);//actualizar stock
Route::post('producto/existe',[ProductoController::class,'existe']); 
});










