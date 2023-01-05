<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return ItemResource::collection(DB::table('items')
        ->whereNot('userId', $id)
        ->where('sold', 'Available')
        ->get());
    }

    public function myListings(int $id)
    {
        return ItemResource::collection(DB::table('items')
        ->whereNot('sold', 'Removed')
        ->where('userId', $id,)
        ->get());
    }

    public function fetchItemSeller(int $id)
    {
        $name = DB::table('users')->where('id', $id)->select('name', 'address')->get();
        
        return $name[0];
    }

    public function remove(int $id) 
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $response = DB::table('items')
        ->where('id', $id)
        ->update(['sold' => 'Removed']);
        
        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Item Removed';
            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Item Remove Unsuccessful';
        return response()->json($responseData, 400);

    }

    public function purchase(int $id, Request $request)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];
        
        $response = DB::table('items')
        ->where('id', $id)
        ->update([
            'soldTo' => $request['soldTo'],
            'sold' => $request['sold']
        ]);

        if($response != null)
        {
            $responseData['status'] = 'success';
            $responseData['message'] = 'Purchase Successful';

            return response()->json($responseData, 200);
        }
        
        $responseData['message'] = 'Purchase Unsuccessful';
        return response()->json($responseData, 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function fetchPicture($picture)
    {   
       return response()->file(storage_path("app/public/uploads/$picture"));
    }

    public function store(Request $request)
    {   
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];


        $file_path = $request['picture']->store('public/uploads');

        $file_name = str_replace("public/uploads/", "", $file_path);
        
        $item = Item::create([
            'name' => $request['name'],
            'details' => $request['details'],
            'price' => $request['price'],
            'userId' => $request['userId'],
            'sold' => $request['sold'],
            'picture' => $file_name
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

        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $response = DB::table('items')
        ->where('id', $id)
        ->update([
            'name' => $request['name'],
            'details' => $request['details'],
            'price' => $request['price'],
            'userId' => $request['userId'],
            'sold' => $request['sold'],
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

    public function updatePicture(int $id, Request $request) {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];

        $file_path = $request['picture']->store('public/uploads');
        $file_name = str_replace("public/uploads/", "", $file_path);

        $response = DB::table('items')
        ->where('id', $id)
        ->update([
            'picture' => $file_name
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
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $responseData = [
            'status' => 'fail',
            'message' => '',
            'data' => null
        ];
        
        $picture = DB::table('items')->where('id', $id)->select('picture')->get();
        $response = DB::table('items')->where('id', $id)->delete();
        
        echo $picture;

        if($response == 0){
            $responseData['message'] = 'Delete Unsuccessful';
            return response()->json($responseData, 200);
        }
        
        $responseData['status'] = 'success';
        $responseData['message'] = 'Item Deleted';

        if(Storage::disk('public')->exists('uploads/' . $picture))
        {   
            echo "WTF";
            Storage::disk('public')->delete('uploads' . $picture);
        }

        return response()->json($responseData, 200);
    }
}
