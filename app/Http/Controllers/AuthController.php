<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
       $data=$request->validate([
        'name'=>'required|string',
        'email'=>'required|email|string|unique:users,email',
        'password'=>[
            'required',
            'confirmed',
            // password::min(8)->mixedCase()->numbers()->symbols()
        ]
        ]);


        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'role'=>$request['role'],
            'password'=>bcrypt($data['password'])
        ]);

        $token=$user->createToken('main')->plainTextToken;


        return response([
            'user'=>$user,
            'token'=>$token
        ]);
    }

    public function login(Request $request){
        $credentials=$request->validate([
       
         'email'=>'required|email|string',
         'password'=>[
             'required',
           
             
         ]
         ]);

         if(!Auth::attempt($credentials)){
            return response([
                'error'=>"The provided credentials are not corrrect"
            ],
            422);
         }

         $user=Auth::user();
         $token=$user->createToken('main')->plainTextToken;

         return response([
            'user'=>$user,
            'token'=>$token
         ]);

        }

        public function logout(){
           $user=Auth::user();
           
           $user->currentAccessToken()->delete();



           return response([
            'success'=>true
           ]);
        }
}
