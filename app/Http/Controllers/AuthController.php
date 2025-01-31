<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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

        return response()->json((['mensaje'=>'Se ja cerrado la sesión']));

        
    }
}
