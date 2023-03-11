<?php

namespace App\Http\Controllers;

// use Ichtrojan\Otp\Otp;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    private $otp;
    public function _construct(){
        $this->otp=new Otp;
    }

    public function email_verification(EmailVerificationRequest $request){
        
        $validUser=Otp::where('token',$request->otp)->first();
        // return response()->json(["success"=> $validUser]);
        //  $otp2=$this->otp->validate($request->email,$request->otp);
        //  return response()->json([ 'success' => $validUser->valid]);
        //  if(!$otp2->status){
        //     return response()->json([ 'error' => $otp2], 401);
        //  }
        if($validUser->valid=='1'){
            $user=User::where('email',$validUser->identifier)->first();
            

            $user->email_verified_at = now();
            $user->save();
           
            
   
            $success['success']=true;
            return response()->json([ $success], 200);
        }
    }
}
