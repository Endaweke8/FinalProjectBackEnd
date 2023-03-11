<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Requests\Stock\StoreStockRequest;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

     public function index(){
       
       
        try{
          $stocksPerPage = 12;
          $stock = Stock::orderBy('updated_at', 'desc')
              ->simplePaginate($stocksPerPage);
              $pageCount = count(Stock::all()) / $stocksPerPage;
  
          return response()->json([
              'stocks' => $stock,
              'page_count' => ceil($pageCount)
          ], 200);
        }
  
      catch (\Exception $e) {
          return response()->json([
              'message' => 'Something went wrong in stockController.index',
              'error' => $e->getMessage()
          ], 400);
      }
  
  
  
       
  
         }




         public function get_total_stocks()
         {
     
         
             try{
              
                  $stockCount = count(Stock::all());
         
                 return response()->json([
                     'totalStocks' => $stockCount,
                     
                 ], 200);
               }
         
             catch (\Exception $e) {
                 return response()->json([
                     'message' => 'Something went wrong in ProductController.get_total_producs',
                     'error' => $e->getMessage()
                 ], 400);
             }
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
    public function store(StoreStockRequest $request)
    {
        // $user=User::first();
        try{
            $stock=Stock::create([
                'name'=>$request['name'],
                'amount'=>$request['amount'],
                'sale_price'=>$request['sale_price'],
                'slug'=>$request['slug'],
                'description'=>$request['description'],
                'image_name'=>$request['image_name'], 
                'status'=>'null'  
            ]);
            if($stock){
            return response()->json([
                'success'=> 'true',
                'stock'=>$stock
            ]);
          }
            // Notification::send($user,new stockNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $stock = Stock::findOrFail($id);

            // if ($request->hasFile('image')) {
            //     (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            // }

            $stock->name = $request->name;
            $stock->slug = $request->slug;
            $stock->description = $request->description;
            $stock->amount = $request->amount;
            $stock->sale_price = $request->sale_price;
            $stock->image_name = $request->image_name;

            $stock->save();

            return response()->json('stock  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in StockController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
 
     public function show(int $id)
     {
         try {
             $stock = Stock::findOrFail($id);
 
             return response()->json($stock, 200);
 
         } catch (\Exception $e) {
             return response()->json([
                 'message' => 'Something went wrong in stockController.show',
                 'error' => $e->getMessage()
             ], 400);
         }
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }


    public function searchStock(Request $request){

        
        if($request->searchData){
            $stocksPerPage = 8;
            $searchStocks=Stock::orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('amount','LIKE','%'.$request->searchData.'%')
            ->orWhere('sale_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('slug','LIKE','%'.$request->searchData.'%')
          
            
            ->get();

            $searchStocksCount=Stock::orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('amount','LIKE','%'.$request->searchData.'%')
            ->orWhere('sale_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('slug','LIKE','%'.$request->searchData.'%')
            
            ->simplePaginate($stocksPerPage);




            $pageCount = count($searchStocks) / $stocksPerPage;




            return response()->json([
                'stocks' =>  $searchStocksCount,
                'page_count' => ceil($pageCount)
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'No search found',
            ]);
        }
       }
}
