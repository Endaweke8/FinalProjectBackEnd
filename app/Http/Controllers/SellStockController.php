<?php

namespace App\Http\Controllers;

use App\Models\SellStock;
use Illuminate\Http\Request;
use App\Http\Requests\SellStockRequest;

class SellStockController extends Controller
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
    public function store(SellStockRequest $request)
    {

       
        // $user=User::first();
        try{
            $sellStock=SellStock::create([
                'firstName'=>$request['firstName'],
                'lastName'=>$request['lastName'],
                'email'=>$request['email'],
                'phone'=>$request['phone'],
                'address'=>$request['address'], 
                'user_id'=>$request['user_id'],
                'stockType'=>$request['stockType'],
                'amount'=>$request['amount'],
                'selling_price'=>$request['selling_price'],
                'description'=>$request['description']

            ]);
            if($sellStock){
            return response()->json([
                'success'=> 'true',
                'sellstock'=>$sellStock
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in MessageController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SellStock  $sellStock
     * @return \Illuminate\Http\Response
     */
    public function show(SellStock $sellStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SellStock  $sellStock
     * @return \Illuminate\Http\Response
     */
    public function edit(SellStock $sellStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SellStock  $sellStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellStock $sellStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SellStock  $sellStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellStock $sellStock)
    {
        //
    }
}
