<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{ 

    public function saveLike(Request $request){

        $likecheck=Like::where(['user_id'=>$request->user_id,'product_id'=>$request->product_id])->first();
        if($likecheck){
            Like::where(['user_id'=>$request->user_id,'product_id'=>$request->product_id])->delete();  
        }

       else{
        $like=new Like;
        $like->user_id=$request->user_id;
        $like->product_id=$request->product_id;
        $like->save();
       }
        return response()->json($request->user_id);
    }
}
