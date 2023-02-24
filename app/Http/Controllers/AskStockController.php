<?php

namespace App\Http\Controllers;

use App\Models\AskStock;
use Illuminate\Http\Request;
use App\Http\Requests\AskStockRequest;

class AskStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_stockrequests()
    {

    
        try{
            $stockPerPage = 8;
            $stockrequests = AskStock::orderBy('updated_at', 'desc')
                ->simplePaginate($stockPerPage);
                $pageCount = count(AskStock::all()) / $stockPerPage;
    
            return response()->json([
                'stockrequests' => $stockrequests,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockController.get_all_stockrequests',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
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
    public function store(AskStockRequest $request)
    {
        {

       
            // $user=User::first();
            try{
                $askStock=AskStock::create([
                    'firstName'=>$request['firstName'],
                    'lastName'=>$request['lastName'],
                    'email'=>$request['email'],
                    'phone'=>$request['phone'],
                    'address'=>$request['address'], 
                    'user_id'=>$request['user_id'],
                    'stockType'=>$request['stockType'],
                    'amount'=>$request['amount'],
                    'buying_price'=>$request['buying_price'],
                    'description'=>$request['description']
    
                ]);
                if($askStock){
                return response()->json([
                    'success'=> 'true',
                    'askstock'=>$askStock
                ]);
              }
                // Notification::send($user,new ProductNotification($request->name));
               
            }
    
            catch (\Exception $e) {
                return response()->json([
                    'message' => 'Something went wrong in AskStockController.store',
                    'errors' => $e->getMessage()
                ], 400);
            }
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AskStock  $askStock
     * @return \Illuminate\Http\Response
     */
    public function show(AskStock $askStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AskStock  $askStock
     * @return \Illuminate\Http\Response
     */
    public function edit(AskStock $askStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AskStock  $askStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AskStock $askStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AskStock  $askStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(AskStock $askStock)
    {
        //
    }
}
