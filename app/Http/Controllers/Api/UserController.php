<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::select('id', 'name', 'contactNo', 'picture','address', 'email')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function addPicture(int $id, Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $response = DB::table('users')
        ->where('id', $id)
        ->update([
            'picture' => $request['picture']
        ]);

        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Profile Photo Added';
            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Photo Upload Unsuccessful';
        return $responseData;
    }

    public function update(int $id, Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $response = DB::table('users')
        ->where('id', $id)
        ->update([
            'name' => $request['name'],
            'contactNo' => $request['contactNo'],
            'address' => $request['address'],
            'picture' => $request['picture'],
        ]);

        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Update Successful';
            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Update Unsuccessful';
        return $responseData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
