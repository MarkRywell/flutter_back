<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {   
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];
        
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'contactNo' => 'required|string|min:10',
            'address' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        if ($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            
            return response()->json($responseData, 400);
        }

        // if ($validator->fails()) {
            // $responseData['message'] = $validator->errors()->first();
            // return response($responseData, 400);
        // }

        $user = User::create([
            'name' => $request['name'],
            'contactNo' => $request['contactNo'],
            'address' => $request['address'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        if ($user == null)
        {   
            $responseData['message'] = 'Unsuccessful Registration';
            return response()->json($responseData, 400);
        }
        
        $responseData['status'] = 'success';
        $responseData['message'] = 'Successful Registration';

        return response()->json($responseData, 201);
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