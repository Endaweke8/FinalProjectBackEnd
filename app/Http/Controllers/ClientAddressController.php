<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientAddress;
use App\Http\Requests\ClientAddressStoreRequest;

class ClientAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(ClientAddressStoreRequest $request)
    {
        // $user=User::first();
        try{
            $clientaddress=ClientAddress::create([
                'user_id'=>$request['user_id'],
                'city'=>$request['city'],
                'subcity'=>$request['subcity'],
                'kebele'=>$request['kebele'], 
                'address'=>$request['address'],
                'phone'=>$request['phone'],
                'email'=>$request['email'], 
                'postal_code'=>$request['postal_code'], 
            ]);
            if($clientaddress){
            return response()->json([
                'success'=> 'true',
                'clientaddress'=>$clientaddress
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CleintAddressController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
     public function show(int $id)
    {
        try {
          
            $clientAddress=ClientAddress::where('user_id',$id)->first();
            return response()->json([
            'clientaddress'=>$clientAddress,
           ],200);

      
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ClientAddressController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientAddress $clientAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
      public function update(ClientAddressStoreRequest $request, int $id)
    {
        try {
            $clientaddress = ClientAddress::where('user_id',$id)->first();

        
            $clientaddress->city = $request->city;
            $clientaddress->subcity = $request->subcity;
            $clientaddress->kebele = $request->kebele;
            $clientaddress->address = $request->address;
            $clientaddress->phone = $request->phone;
            $clientaddress->postal_code = $request->postal_code;
             $clientaddress->email = $request->email;

            $clientaddress->save();

            return response()->json('client address  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ClientAddressController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientAddress $clientAddress)
    {
        //
    }
}
