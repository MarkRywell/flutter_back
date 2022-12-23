<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {   
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($user == null)
        {   
            $responseData['message'] = 'Unsuccessful Registration';
            return response($responseData, 400);
        }

        $user->save();
        
        $responseData['status'] = 'success';
        $responseData['message'] = 'Successful Registration';
        return response($responseData, 201);
    }

    public function login(Request $request)
    {   
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null,
        ];

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)) {
            $responseData['message'] = 'Unsuccessful Login';

            return response($responseData, 400);
        }

        $user = $request->user();
    
        $responseData = [
            'status' => 'success',
            'message' => 'Successful Login',
            'data' => [
                'user' => Auth::user(),
                'token' => $user->createToken('onlysells')->plainTextToken
            ]
        ];

        return response($responseData, 200);
    }

    
}