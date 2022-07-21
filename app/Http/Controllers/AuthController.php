<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Http\FormRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    //Función para iniciar sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user->assignRole($request->Role),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
        ]);
    }
    
    //Función para Mostrar datos
    public function me(){
        return response()->json(auth()->user());
    }


    //Función para cerrar sesión
    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        } else if (Auth::invalidate($request->token)) {
            auth()->logout();
            return response()->json(['message' => 'Su sesión ha finalizado exitosamente']);
        }
    }

    //Función para refrescar el token
    public function refresh(){
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    //Función para registrar
    public function register(Request $request){
        $user = new User;

        $validator = validator::make($request->all(), [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|min:6',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)],
        ));
        
        $token = Auth::fromUser($user);
        $request->Role = 'cliente';
        $user->assignRole("cliente");
        

        return response()->json([
            'message'=> 'Usuario registrado exitosamente',
            'user' => $user,
            'token' => $token,
        ],201);
    }


}
