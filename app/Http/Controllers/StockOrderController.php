<?php

namespace App\Http\Controllers;

use App\Models\StockOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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



    public function get_total_stockorder()
    {

    
        try{
         
             $stockOrderCount = count(StockOrder::all());
    
            return response()->json([
                'totalStockOrders' => $stockOrderCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockOrderController.get_total_stockorders',
                'error' => $e->getMessage()
            ], 400);
        }
    }




    public function get_all_stockorders()
    {

    
        try{
            $stockPerPage = 8;
            $stockorders = StockOrder::orderBy('updated_at', 'desc')
                ->simplePaginate($stockPerPage);
                $pageCount = count(StockOrder::all()) / $stockPerPage;
    
            return response()->json([
                'stockorders' => $stockorders,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockOrderController.get_all_stockorders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
    }



    public function get_all_stockordersdailyreport()
    {

        try{
            $date = Carbon::today()->subDays(1);
            $stockPerPage = 8;
            $stockorders = StockOrder::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->simplePaginate($stockPerPage);
                $pageCount = count(StockOrder::where('updated_at', '>=', $date)->get()) / $stockPerPage;


            return response()->json([
                'stockorders' => $stockorders,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockOrderController.get_all_stockorders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
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



    public function searchStockOrder(Request $request){

        
        if($request->searchData){
            $stocksOrdersPerPage = 8;
            $searchStocksOrders=StockOrder::orderBy('updated_at', 'desc')
            ->where('firstName','LIKE','%'.$request->searchData.'%')
            ->orWhere('lastName','LIKE','%'.$request->searchData.'%')
            ->orWhere('email','LIKE','%'.$request->searchData.'%')
            ->orWhere('phone','LIKE','%'.$request->searchData.'%')
            ->where('address','LIKE','%'.$request->searchData.'%')
           
            ->orWhere('amount','LIKE','%'.$request->searchData.'%')
            ->orWhere('buying_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('user_id','LIKE','%'.$request->searchData.'%')
          
            
            ->get();

            $searchStocksOrdersCount=StockOrder::orderBy('updated_at', 'desc')
            ->where('firstName','LIKE','%'.$request->searchData.'%')
            ->orWhere('lastName','LIKE','%'.$request->searchData.'%')
            ->orWhere('email','LIKE','%'.$request->searchData.'%')
            ->orWhere('phone','LIKE','%'.$request->searchData.'%')
            ->where('address','LIKE','%'.$request->searchData.'%')
           
            ->orWhere('amount','LIKE','%'.$request->searchData.'%')
            ->orWhere('buying_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('user_id','LIKE','%'.$request->searchData.'%')
            
            ->simplePaginate($stocksOrdersPerPage);




            $pageCount = count($searchStocksOrders) / $stocksOrdersPerPage;




            return response()->json([
                'stockorders' =>  $searchStocksOrdersCount,
                'page_count' => ceil($pageCount)
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'No search found',
            ]);
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
