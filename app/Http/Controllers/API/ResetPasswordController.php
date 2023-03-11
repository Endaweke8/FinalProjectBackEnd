<?php

namespace App\Http\Controllers\API;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function ResetPassword(ResetPasswordRequest $request){
        
       
        try {
            $validUser=Otp::where('token',$request->token)->first();
            if($validUser->valid=='1'){
                $user=User::where('email',$validUser->identifier)->first();
                $user->email_verified_at = now();
                $user->password=Hash::make($request->password);
                $user->save();
                if($user->save())
               {
                Otp::where('token',$request->token)->delete();
                return response()->json([ "success"=>true], 200);
               }
            }
            

        }catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in ResetPassword.ResetPassword'
            ]);
        }
    }

}
