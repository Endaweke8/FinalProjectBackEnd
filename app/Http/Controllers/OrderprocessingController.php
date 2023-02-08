<?php

namespace App\Http\Controllers;

use App\Models\Processing;
use Illuminate\Http\Request;

class OrderprocessingController extends Controller
{
    public function getOrders()
    {

    
        try{
            $ordersPerPage = 8;
            $order = Processing::orderBy('updated_at', 'desc')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::all()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }

    public function searchOrder(Request $request){
  
        if($request->searchData){
            $ordersPerPage = 8;
            $searchOrders=Processing::orderBy('updated_at', 'desc')->where('client_name','LIKE','%'.$request->searchData.'%')
            ->orWhere('client_id','LIKE','%'.$request->searchData.'%')
            ->orWhere('client_address','LIKE','%'.$request->searchData.'%')
            ->orWhere('amount','LIKE','%'.$request->searchData.'%')
            ->orWhere('currency','LIKE','%'.$request->searchData.'%')
           
          
            
            ->get();

            $searchOrdersCount=Processing::orderBy('updated_at', 'desc')->where('client_name','LIKE','%'.$request->searchData.'%')
            ->orWhere('client_id','LIKE','%'.$request->searchData.'%')
            ->orWhere('client_address','LIKE','%'.$request->searchData.'%')
            ->orWhere('amount','LIKE','%'.$request->searchData.'%')
            ->orWhere('currency','LIKE','%'.$request->searchData.'%')
         
            ->simplePaginate($ordersPerPage);




            $pageCount = count($searchOrders) / $ordersPerPage;




            return response()->json([
                'orders' =>  $searchOrdersCount,
                'page_count' => ceil($pageCount)
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'No search found',
            ]);
        }
       }



       public function searchOrderResponse(Request $request){
            try {
                
             if($request->searchData){
             
            $searchOrders=Processing::orderBy('updated_at', 'desc')->where('client_id',$request->client_id)->where('client_name','LIKE','%'.$request->searchData.'%','client_id','LIKE','%'.$request->searchData.'%')
             
            ->get();


            return response()->json([
                'orders' =>  $searchOrders,
               
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'No search found',
            ]);
        }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Something went wrong in OrderprocessingController.searchOrderResponse',
                    'error' => $e->getMessage()
                ], 400);
            }
       }


       public function get_total_transactions()
       {
   
       
           try{
            
                $orderCount = count(Processing::all());
       
               return response()->json([
                   'totalTransactions' => $orderCount,
                   
               ], 200);
             }
       
           catch (\Exception $e) {
               return response()->json([
                   'message' => 'Something went wrong in OrderprocessingController.get_total_transactions',
                   'error' => $e->getMessage()
               ], 400);
           }
        }

        public function get_total_sales()
        {
    
        
            try{
             
                 $saleCount = Processing::sum('amount');
        
                return response()->json([
                    'totalSales' => $saleCount,
                    
                ], 200);
              }
        
            catch (\Exception $e) {
                return response()->json([
                    'message' => 'Something went wrong in OrderprocessingController.get_total_sales',
                    'error' => $e->getMessage()
                ], 400);
            }
         }
        // 'items'=>Cart::where('user_id',$user->id)->sum('quantity'),

    public function destroy(int $id)
    {
        try {
            $order = Processing::findOrFail($id);
            $order->delete();

            return response()->json('Order deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProcessingController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function MarkAsDelivered(Request $request, int $id)
    {
        try {
            $processing = Processing::findOrFail($id);
            $processing->status = $request->status;
            $processing->save();

            return response()->json('Processing table  updated as delivered', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrederProcessingController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    public function show(int $id)
    {
        try {
            $processing=Processing::orderBy('updated_at', 'desc')->where('client_id',$id)->get();

           return response()->json([
              
              'orderResponse'=>$processing,
          ], 200);
    }  catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in OrderProcessing.show',
            'error' => $e->getMessage()
        ], 400);
    }
    }
}
