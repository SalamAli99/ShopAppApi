<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   
   
     public function sign_up(Request $request){
        try{
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res,201);
    }
   catch(Exception $e){
    return response(['error' => $e->getMessage()], 500);
}
}


        public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'msg' => 'incorrect username or password'
            ], 401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];

        return response($res, 201);
    }

    public function logout(Request $request)
    {
           try {
        $user = auth()->user();
        if (!$user) {
            return response(['message' => 'Unauthenticated'], 401);
        }

        $user->tokens()->delete();

        return [
            'message' => 'User logged out'
        ];
    } catch (Exception $e) {
        Log::error('Logout Error: ' . $e->getMessage());
        return response(['error' => 'Server error.'], 500);

    }


}
}
