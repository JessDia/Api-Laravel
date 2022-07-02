<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            
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
        'user' => $user,
        'authorisation' => [
        'token' => $token,
        'type' => 'bearer',
        ]
        ]);
    }

    public function me(){
    return response()->json(auth()->user());
    }


    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Su sesión ha finalizado exitosamente']);
    }

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


    public function register(Request $request){
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)],
        ));
        
        
        $token = Auth::fromUser($user);

        $user->assignRole("cliente");

        return response()->json([
        'message'=> 'Usuario registrado exitosamente',
        'user' => $user,
        'token' => $token,
        ],201);
        
        // switch (Auth::user()->type_user) {
        //     case ('1'):
        //         $user->assignRole("admin");
        //         break;
        //     case ('2'):
        //         $user->assignRole("vendedor");
        //     break;
        //     case ('3'):
        //     $user->assignRole("cliente");
        //     default:
        //     return "Debe seleccionar un tipo de usuario valido";
        //     break;
        // }

        

        
    }
}
