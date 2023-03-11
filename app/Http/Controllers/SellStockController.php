<?php

namespace App\Http\Controllers;

use App\Models\SellStock;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\SellStockRequest;

class SellStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_sellstockrequests()
    {

    
        try{
            $stockPerPage = 8;
            $sellstockrequests = SellStock::orderBy('updated_at', 'desc')
                ->simplePaginate($stockPerPage);
                $pageCount = count(SellStock::all()) / $stockPerPage;
    
            return response()->json([
                'sellstockrequests' => $sellstockrequests,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockController.get_all_sellstockrequest',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
    }


    public function get_all_sellstockrequestsdailyreport()
    {

    
        try{
            $date = Carbon::today()->subDays(1);
            $stockPerPage = 8;
            $sellstockrequests = SellStock::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->simplePaginate($stockPerPage);
                $pageCount = count(SellStock::where('updated_at', '>=', $date)->get()) / $stockPerPage;
    
            return response()->json([
                'sellstockrequests' => $sellstockrequests,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockController.get_all_sellstockrequest',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
    }
  

    public function get_all_sellstockrequestsweeklyreport()
    {

    
        try{
            $date = Carbon::today()->subDays(7);
            $stockPerPage = 8;
            $sellstockrequests = SellStock::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->simplePaginate($stockPerPage);
                $pageCount = count(SellStock::where('updated_at', '>=', $date)->get()) / $stockPerPage;
    
            return response()->json([
                'sellstockrequests' => $sellstockrequests,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockController.get_all_sellstockrequest',
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


     public function searchsellStockRequests(Request $request){
 
        try {
        
            if($request->searchData){
                $sellstocksRequestsPerPage = 8;
                $searchSellStocksRequest=SellStock::orderBy('updated_at', 'desc')
                ->where('firstName','LIKE','%'.$request->searchData.'%')
                ->orWhere('lastName','LIKE','%'.$request->searchData.'%')
                ->orWhere('email','LIKE','%'.$request->searchData.'%')
                ->orWhere('phone','LIKE','%'.$request->searchData.'%')
                ->where('address','LIKE','%'.$request->searchData.'%')
                ->orWhere('stockType','LIKE','%'.$request->searchData.'%')
                ->orWhere('amount','LIKE','%'.$request->searchData.'%')
                ->orWhere('selling_price','LIKE','%'.$request->searchData.'%')
                ->orWhere('user_id','LIKE','%'.$request->searchData.'%')
              
                
                ->get();
    
                $searchSellStocksRequestCount=SellStock::orderBy('updated_at', 'desc')
                ->where('firstName','LIKE','%'.$request->searchData.'%')
                ->orWhere('lastName','LIKE','%'.$request->searchData.'%')
                ->orWhere('email','LIKE','%'.$request->searchData.'%')
                ->orWhere('phone','LIKE','%'.$request->searchData.'%')
                ->where('address','LIKE','%'.$request->searchData.'%')
                ->orWhere('stockType','LIKE','%'.$request->searchData.'%')
                ->orWhere('amount','LIKE','%'.$request->searchData.'%')
                ->orWhere('selling_price','LIKE','%'.$request->searchData.'%')
                ->orWhere('user_id','LIKE','%'.$request->searchData.'%')
                
                ->simplePaginate($sellstocksRequestsPerPage);
    
    
    
    
                $pageCount = count($searchSellStocksRequest) / $sellstocksRequestsPerPage;
    
    
    
    
                return response()->json([
                    'sellstockrequests' =>  $searchSellStocksRequestCount,
                    'page_count' => ceil($pageCount)
                ], 200);
            }
                   }  catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in SellStockController.searchSellStock',
                'error' => $e->getMessage()
            ], 400);
        }   

       }




       public function get_total_sellstockrequested()
       {
   
       
           try{
            
                $sellStockRequestedCount = count(SellStock::all());
               return response()->json([
                   'totalSellStockRequested' => $sellStockRequestedCount,
               ], 200);
             }
       
           catch (\Exception $e) {
               return response()->json([
                   'message' => 'Something went wrong in SellStockController.get_totalSellStock_requested',
                   'error' => $e->getMessage()
               ], 400);
           }
       }
    
    
       /**
     * Display the specified resource.
     *
     * @param  \App\Models\SellStock  $askStock
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
