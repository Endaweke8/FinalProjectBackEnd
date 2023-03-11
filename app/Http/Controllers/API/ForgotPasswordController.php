<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;

class ForgotPasswordController extends Controller
{
    // private $otp;
    // public function _construct(){
    //     $this->otp=new Otp;
    // }

    public function ForgetPassword(ForgetPasswordRequest $request){
        try {
            
        $otp=new Otp();
        $otpp=$otp->generate($request->email,6,60);
        $mail_data=[
                
            'recipient'=> $request->email,
            'fromEmail'=>'endaweke1234@gmail.com',
            'fromName'=>'endaweke',
            'subject'=>"Forget Password Code",
            'body'=>$otpp->token,
           ];
           \Mail::send('email-template',$mail_data,function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
            ->from($mail_data['fromEmail'],$mail_data['fromName'])
            ->subject($mail_data['subject']);
           });

           return response()->json([
            'code' =>$otpp->token,
            
        ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in ForgotPassword.forgetPassword'
            ]);
        }
    }
}
