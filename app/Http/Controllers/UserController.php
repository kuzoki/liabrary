<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
class UserController extends Controller
{
    //
    public function init(){
        $user = Auth::user();
        return ["user" => $user  ];
    }

    public function register(Request $request){
        
        
           
        $request->validate( [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
       
        

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
    }

    public function login(Request $request){
        $request->validate( [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if( Auth::attempt($request->only('email','password'))){
            return response()->json( Auth::user(), 200);
        }

        
        
        throw ValidationException::withMessages([
            'email' =>['Please Enter The Correct Information, if Not register You Should do first'],
        ]);
        
    }

    public function logout(){
        Auth::logout();
    }


    public function checkLogin(Request $request){
       $gin = Auth::check();
       if(!$gin){
            return true;
       }else{
           return false;
       }
        
    }
}
