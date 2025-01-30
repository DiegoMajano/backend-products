<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //metood para login

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=> ''
        ]);


        if($validator->fails()){
            return response()->json([
                'meesage' => 'Validator error', 
                'errors'=> $validator->errors()
            ],400);
        }
    }
}
