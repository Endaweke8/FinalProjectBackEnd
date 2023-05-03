<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Processing;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderprocessingController extends Controller
{
    public function getOrders()
    {

    
        try{
            $date = Carbon::today()->subDays(1);
            $ordersPerPage = 8;
            $order = Processing::orderBy('created_at', 'desc')->where('created_at', '<', $date)
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



    public function getDailyReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(1);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('updated_at', '>=', $date)->get()) / $ordersPerPage;
            $totalDailyProfit=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->sum('profit');
                 $totalDailySaleAmount=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->sum('amount');
                    $totalDailyBuyingPrice=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->sum('total_buying_price');

            return response()->json([
                'orders' => $order,
                'totalProfit' => $totalDailyProfit,
                'totalDailySaleAmount' => $totalDailySaleAmount,
                'totalDailyBuyingPrice' => $totalDailyBuyingPrice,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }

    
    public function getWeeklyReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(7);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('created_at', 'desc')->where('created_at', '>=', $date)
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('created_at', '>=', $date)->get()) / $ordersPerPage;


                $totalWeeklyProfit=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->sum('profit');
                 $totalWeeklySaleAmount=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->sum('amount');
                    $totalWeeklyBuyingAmount=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->sum('total_buying_price');
    
            return response()->json([
                'orders' => $order,
                'totalProfit' => $totalWeeklyProfit,
                'totalWeeklySaleAmount' => $totalWeeklySaleAmount,
                'totalWeeklyBuyingAmount' => $totalWeeklyBuyingAmount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getWeeklyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }





    public function getDailyAcceptedReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(1);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('accepted','accepted')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('updated_at', '>=', $date)->where('accepted','accepted')->get()) / $ordersPerPage;
            
            $totalDailyAcceptedProfit=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('accepted','accepted')
                ->sum('profit');
                 $totalDailyAcceptedSaleAmount=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('accepted','accepted')
                ->sum('amount');
                    $totalDailyAcceptedBuyingPrice=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('accepted','accepted')
                ->sum('total_buying_price');

            return response()->json([
                'orders' => $order,
                'totalProfit' => $totalDailyAcceptedProfit,
                'totalDailyAcceptedSaleAmount' => $totalDailyAcceptedSaleAmount,
                'totalDailyAcceptedBuyingPrice' => $totalDailyAcceptedBuyingPrice,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }



    public function getWeeklyAcceptedReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(7);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('accepted','accepted')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('updated_at', '>=', $date)->where('accepted','accepted')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }




    public function getDailyPendingReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(1);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','pending')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('updated_at', '>=', $date)->where('status','pending')->get()) / $ordersPerPage;

                $totalDailyPendingProfit=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','pending')
                ->sum('profit');
                 $totalDailyPendingSaleAmount=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','pending')
                ->sum('amount');
                    $totalDailyPendingBuyingPrice=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','pending')
                ->sum('total_buying_price');
    
            return response()->json([
                'orders' => $order,
                'totalDailyPendingProfit' => $totalDailyPendingProfit,
                'totalDailyPendingSaleAmount' => $totalDailyPendingSaleAmount,
                'totalDailyPendingBuyingPrice' => $totalDailyPendingBuyingPrice,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }



    public function getWeeklyPendingReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(7);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('created_at', 'desc')->where('created_at', '>=', $date)->where('status','pending')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('created_at', '>=', $date)->where('status','pending')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }

    public function getDailyDeliveredReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(1);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','delivered')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('updated_at', '>=', $date)->where('status','delivered')->get()) / $ordersPerPage;

                 $totalDailyDeliveredProfit=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','delivered')
                ->sum('profit');
                 $totalDailyDeliveredSaleAmount=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','delivered')
                ->sum('amount');
                    $totalDailyDeliveredBuyingPrice=Processing::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)->where('status','delivered')
                ->sum('total_buying_price');

    
            return response()->json([
                'orders' => $order,
                'totalDailyDeliveredProfit' => $totalDailyDeliveredProfit,
                'totalDailyDeliveredSaleAmount' => $totalDailyDeliveredSaleAmount,
                'totalDailyDeliveredBuyingPrice' => $totalDailyDeliveredBuyingPrice,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }


    
    public function getWeeklyDeliveredReportOrders()
    {

        try{
            $date = Carbon::today()->subDays(7);
            // Product::where('updated_at', '<', $date)->
            $ordersPerPage = 8;
            $order = Processing::orderBy('created_at', 'desc')->where('created_at', '>=', $date)->where('status','delivered')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('created_at', '>=', $date)->where('status','delivered')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getDailyReportOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }




    public function getPendingOrders()
    {

    
        try{
             $date = Carbon::today()->subDays(1);
            $ordersPerPage = 8;
            $order = Processing::where('status','pending')->where('updated_at', '<', $date)->orderBy('updated_at', 'desc')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('status','pending')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getPendingOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }



    public function getDeliveredOrders()
    {

    
        try{
            $date = Carbon::today()->subDays(1);
            $ordersPerPage = 8;
            $order = Processing::where('status','delivered')->where('updated_at', '<', $date)->orderBy('updated_at', 'desc')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('status','delivered')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getPendingOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }



    public function getNotifiedOrders()
    {

    
        try{
            $ordersPerPage = 8;
            $order = Processing::where('notified','notified')->orderBy('updated_at', 'desc')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('notified','notified')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getPendingOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }


  
    public function acceptedOrders()
    {

    
        try{
            $ordersPerPage = 8;
            $order = Processing::where('accepted','accepted')->orderBy('updated_at', 'desc')
                ->simplePaginate($ordersPerPage);
                $pageCount = count(Processing::where('accepted','accepted')->get()) / $ordersPerPage;
    
            return response()->json([
                'orders' => $order,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderprocessingController.getPendingOrders',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    }

    public function searchOrder(Request $request){
  
        if($request->searchData){
             $date = Carbon::today()->subDays(1);
            $ordersPerPage = 8;
            $searchOrders= Processing::orderBy('created_at', 'desc')->where('created_at', '<', $date)->where('client_name','LIKE','%'.$request->searchData.'%')
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



         public function searchTodaysOrder(Request $request){
  
            if($request->todaysQueryOrder){
            $date = Carbon::today()->subDays(1);
            $ordersPerPage = 8;
            $searchTodaysOrders= Processing::orderBy('created_at', 'desc')->where('created_at', '>=', $date)->where('client_name','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('client_id','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('client_address','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('amount','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('currency','LIKE','%'.$request->todaysQueryOrder.'%')
           
          
            
            ->get();

            $searchTodaysOrdersCount=Processing::orderBy('updated_at', 'desc')->where('client_name','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('client_id','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('client_address','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('amount','LIKE','%'.$request->todaysQueryOrder.'%')
            ->orWhere('currency','LIKE','%'.$request->todaysQueryOrder.'%')
         
            ->simplePaginate($ordersPerPage);




            $pageCount = count($searchTodaysOrders) / $ordersPerPage;




            return response()->json([
                'todaysorder' =>  $searchTodaysOrdersCount,
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




    public function get_total_pendingorders()
    {

    
        try{
         
             $pendingOrdersCount = count(Processing::where('status','pending')->get());
    
            return response()->json([
                'pendingOrders' => $pendingOrdersCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderProcessingController.pendingorders',
                'error' => $e->getMessage()
            ], 400);
        }
    }



    public function get_total_deliveredorders()
    {

    
        try{
         
             $deliverOrderCount = count(Processing::where('status','delivered')->get());
    
            return response()->json([
                'deliveredOrders' => $deliverOrderCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderProcessingController.pendingorders',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    

    public function get_total_notifiedorders()
    {

    
        try{
         
             $notifiedOrders = count(Processing::where('notified','notified')->get());
    
            return response()->json([
                'notifiedOrders' => $notifiedOrders,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderProcessingController.notifedorders',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function get_total_acceptedorders()
    {

    
        try{
         
             $acceptedCount = count(Processing::where('accepted','accepted')->get());
    
            return response()->json([
                'acceptedOrders' => $acceptedCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrderProcessingController.acceptedorders',
                'error' => $e->getMessage()
            ], 400);
        }
    }










    public function NotifyDeliveryMan(Request $request, int $id)
    {

        //   $user=User::where('role','delivery')->get();
          $deliveryemail=  User::where('role','delivery')->first()->email;
          $customerserviceofficoremail=  User::where('role','customerserviceofficor')->first()->email;
          $customerserviceofficorename=  User::where('role','customerserviceofficor')->first()->name;

        try {
            $processing = Processing::findOrFail($id);
            $processing->notified = $request->notified;
            $processing->save();




            // $request->validate([
            //     'name'=>'required',
            //     'email'=>'required|email',
            //     'subject'=>'required',
            //     'message'=>'required'
            // ]);
          
               $mail_data=[
                
                'recipient'=>$deliveryemail,
                'fromEmail'=>$customerserviceofficoremail,
                'fromName'=>$customerserviceofficorename,
                'subject'=>"Order id ".$processing->id."  must be delivered",
                'body'=>$processing,
               ];
               \Mail::send('email-template',$mail_data,function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'],$mail_data['fromName'])
                ->subject($mail_data['subject']);
               });
    


            return response()->json('Processing table  updated as notified', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrederProcessingController.NotifyDeliveryMan',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    public function NotifyAsAccepted(Request $request, int $id)
    {
        try {
            $manageremail=  User::where('role','manager')->first()->email;
            $useremail= $request->email;
            $username= $request->name;
            $userid=$request->userid;
            $processing = Processing::findOrFail($id);
            $processing->accepted = $request->accepted;
            $processing->save();



            $mail_data=[
                
                'recipient'=>'endaweke1234@gmail.com',
                'fromEmail'=>$useremail,
                'fromName'=>$username,
                'subject'=>"Customer  ".$username." with user id ".$userid."  accepted  order id ".$processing->id,
                'body'=>$processing,
               ];
               \Mail::send('email-template',$mail_data,function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'],$mail_data['fromName'])
                ->subject($mail_data['subject']);
               });

            return response()->json('Processing table  updated as accepted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in OrederProcessingController.NotifyAsAccepted',
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


    public function showOrderResponseDetail(int $id)
    {
        try {
            $processing=Processing::find($id);

           return response()->json([
              
              'orderResponse'=>$processing,
          ], 200);
    }  catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in OrderProcessing.showOrderResponseDetail',
            'error' => $e->getMessage()
        ], 400);
    }
    }
}
