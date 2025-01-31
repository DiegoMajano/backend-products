<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validar datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Devolver errores de validación
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        // Generar token de acceso
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    //metood para login

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=> 'required|string'
        ]);


        if($validator->fails()){
            return response()->json([
                'meesage' => 'Validator error', 
                'errors'=> $validator->errors()
            ],400);
        }

        $email=$request->input('email');
        $password=$request->input('password');

        $user = User::where('email',$email)->where('password','=',$password)->first();

        if($user){
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                "user"=>$email, 
                "token"=>$token,
            ],200);
        } else{
            return response()->json(['message' => 'You are not authorized'], 401);
        }
    
    
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        return response()->json((['mensaje'=>'Se ha cerrado la sesión']));

    }
}
