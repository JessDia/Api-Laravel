<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Rutas para la autenticación
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function($route){
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('me',[AuthController::class,'me'])->middleware(['jwt.auth']);
    Route::post('register',[AuthController::class,'register']);
});

//CRUD usuarios
Route::group(['role:admin', 'permission:ver.usuarios|crear.usuarios|obtener.usuarios|
actualizar.usuarios|eliminar.usuarios'], function(){
    Route::group(['middleware' => ['admin.access']], function(){
        Route::controller(UserController::class)->group(function(){
            Route::get('User/get','index');//->middleware('canAccess'); // mostrar usuarios
            Route::post('User/create','store'); //Crear un nuevo usuario 
            Route::put('User/update/{id}','update'); //actualizar usuario
            Route::get('User/show/{id}','show'); // Obtener los datos de un usuario
            Route::delete('User/delete/{id}','destroy'); //eliminar usuario 
        });
    });
    
});
    
Route::group(['middleware' => ['role:admin|vendedor','permission:listar.productos|crear.productos|obtener.producto|
// actualizar.producto|eliminar.producto']], function () {
    Route::controller(ProductoController::class)->group(function(){
        Route::get('productos','index'); //Mostrar los productos
        Route::post('productos','store'); //Crear productos
        // Route::patch('productos/{id}', 'edit'); //editar producto
        Route::get('productos/{id}','show');//Mostrar producto por id
        Route::put('productos/{id}','update'); //actualizar producto
        Route::delete('productos/{id}','destroy'); //eliminar producto
    
    });
});

Route::group(['middleware' => ['client.access']], function (){
    Route::get('productos',[ProductoController::class,'index']); //Mostrar los productos
    Route::put('productos/{id}',[ProductoController::class,'update']); //actualizar producto
});







