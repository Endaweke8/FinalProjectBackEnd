<?php

namespace App\Http\Controllers;

use App\Models\StockOrder;
use Illuminate\Http\Request;
use App\Http\Requests\StockOrderRequest;

class StockOrderController extends Controller
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
    public function store(StockOrderRequest $request)
    {

       
        // $user=User::first();
        try{
            $stockOrder=StockOrder::create([
                'firstName'=>$request['firstName'],
                'lastName'=>$request['lastName'],
                'email'=>$request['email'],
                'phone'=>$request['phone'],
                'address'=>$request['address'], 
                'user_id'=>$request['user_id'],
                'stock_id'=>$request['stock_id'],
                'amount'=>$request['amount'],
                'buying_price'=>$request['buying_price'],

            ]);
            if($stockOrder){
            return response()->json([
                'success'=> 'true',
                'stockorder'=>$stockOrder
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
     * @param  \App\Models\StockOrder  $stockOrder
     * @return \Illuminate\Http\Response
     */
    public function show(StockOrder $stockOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockOrder  $stockOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(StockOrder $stockOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockOrder  $stockOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockOrder $stockOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockOrder  $stockOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockOrder $stockOrder)
    {
        //
    }
}
