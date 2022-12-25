<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ItemResource::collection(DB::table('items')->get());
    }

    public function fetchOtherItems(int $id)
    {
        return (DB::table('items')->whereNot('userId', $id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $item = Item::create([
            'name' => $request['name'],
            'details' => $request['details'],
            'userId' => $request['userId'],
            'sold' => $request['sold'],
            'picture' => $request['picture'],
        ]);
        
        if ($item == null)
        {
            $responseData['message'] = 'Unsuccessful Add Item';
            return response()->json($responseData, 400);
        }

        $responseData['status'] = 'success';
        $responseData['message'] = 'Item Added Successfully';

        return response()->json($responseData, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        return ItemResource::collection(DB::table('items')->where('userId', $userId)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        $response = DB::table('items')
        ->where('id', $id)
        ->update([
            'name' => $request['name'],
            'details' => $request['details'],
            'userId' => $request['userId'],
            'sold' => $request['sold'],
            'picture' => $request['picture'],
            'soldTo' => $request['soldTo']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
