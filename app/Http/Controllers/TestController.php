<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function please(Request $request){

     //  $otp2=$this->otp->validate($request->email,$request->otp);
         

        //  if(!$otp2->status){
        //     return response()->json([ 'error' => $otp2], 401);
        //  }
        //  $user=User::where('email',$request->email)->first();
        //  $user->update(['email_verified_at'=>now()]);

        //  $success['success']=true;
        //  return response()->json([ $success], 200);
        try {
            return response()->json([ 'request' => $request]);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in TestController.verify_email',
                'errors' => $e->getMessage()
            ], 400);
        }
    
    }
}
