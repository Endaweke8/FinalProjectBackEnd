<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function addRate(Request $request){
       try{
        $stars_rated=$request->input('stars_rated');
        $product_id=$request->input('product_id');
        $user_id=$request->input('user_id');
        $exsisting_rating=Rating::where('user_id',$user_id)->where('product_id',$product_id)->first();
        if($exsisting_rating)
        {
            $exsisting_rating->stars_rated=$stars_rated;
            $exsisting_rating->update();
        }
         else{
            Rating::create([
                'user_id'=>$user_id,
                'product_id'=>$product_id,
                'stars_rated'=>$stars_rated,
             ]);
         }
          $ratings=Rating::where('product_id',$product_id)->sum('stars_rated');
          $ratingsCount=Rating::where('product_id',$product_id)->count();
          $rategiven=$ratings/$ratingsCount;
          
         return response()->json([
            'success' => $exsisting_rating,
            'status' => "Thank you for Your review",
            'ratings'=>$ratings,
            'ratingsCount'=>$ratingsCount,
            'totalRateGiven'=>$rategiven,
        ], 200);
      

       }catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in RatingController.addRate',
            'error' => $e->getMessage()
        ], 400);

        // $product_check=Product::where('id',$product_id)->where('status','0')->first();

        // if($product_check){
        //     $verified_purchase=Processing::where('processings.client_id',$user_id)
        //     ->join('order_details','processings.id')
        //     ->where('order_details.id',$product_id)->get();
        // }
    }

    }
    public function show(int $id)
    {
        try {
            $ratings=Rating::where('product_id',$id)->sum('stars_rated');
            $ratingsCount=Rating::where('product_id',$id)->count();
            $rategiven=$ratings/$ratingsCount;
            
           return response()->json([
              'status' => "by id",
              'ratings'=>$ratings,
              'ratingsCount'=>$ratingsCount,
              'totalRateGiven'=>$rategiven,
          ], 200);
    }  catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in RateController.show',
            'error' => $e->getMessage()
        ], 400);
    }
}
}