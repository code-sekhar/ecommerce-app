<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    public function register(Request $request) {
       try{
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
         ]);
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
         ]);
         $token = $user->createToken('auth_token')->plainTextToken;
         return response()->json([
             'message' => 'User created successfully',
             'token' => $token,
             'user' => $user
         ], 201);
       }catch(Exception $e) {
           return response()->json([
               'message' => $e->getMessage()
           ], 500);
       }
    }
}
