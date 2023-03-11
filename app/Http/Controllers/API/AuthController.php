<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\LoginNotification;
use App\Http\Requests\Auth\LogoutRequest;
use App\Notifications\ProductNotification;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)

    {
        $otp=new Otp();
        try {
         
           if($request->input('role')){
            $userr = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => Hash::make($request->input('password'))
            ]);
           }else{
            $userr = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
           }
          

            $token = $userr->createToken('user_token')->plainTextToken;
            $user=User::first();
            $message=$request->input('first_name')." Registered";
            Notification::send($user,new ProductNotification( $request->input('first_name'),$message));
            $otpp=$otp->generate($request->input('email'),6,60);
            $mail_data=[
                
                'recipient'=> $request->input('email'),
                'fromEmail'=>'endaweke1234@gmail.com',
                'fromName'=>'enawke',
                'subject'=>"for Email Verification",
                'body'=>$otpp->token,
               ];
               \Mail::send('email-template',$mail_data,function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'],$mail_data['fromName'])
                ->subject($mail_data['subject']);
               });


            return response()->json([ 'user' => $userr, 'token' => $token,'mail'=>$mail_data ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.register'
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        try {

            $user = User::where('email', '=', $request->input('email'))->firstOrFail();


            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('user_token')->plainTextToken;

                return response()->json([ 'user' => $user, 'token' => $token ], 200);
            }
            

            return response()->json([ 'errors' => 'Something went wrong in login' ]);

        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.login'
            ]);
        }
    }

    public function logout(LogoutRequest $request)
    {
        try {

            $user = User::findOrFail($request->input('user_id'));

            $user->tokens()->delete();

            return response()->json('User logged out!', 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }

   public function forgetPassword(Request $request){

    try {
        $user=User::where('email',$request->email)->get();
         if(count($user)>0){

            $token=Str::random(40);
            $domain=URL::to('/');
            $url=$domain.'/reset-password?'.$token;
            $data['url']=$url;
            $data['email']=$request->email;
            $data['title']="Password Reset";
            $data['body']="Please click the link below to reset you password";
  

            Mail::send('forgetPasswordMail',['data'=>$data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);               

               $date_time=Carbon::now()->format('Y-m-d H:i:s');
               PasswordReset::updateOrCreate(
                ['email'=>$request->email],
                [
                    'email'=>$request->email,
                    'token'=>$token,
                    'created_at'=>$date_time
                ]
               );

                return response()->json([
                    'message' => 'Please Check Your Mail',
                    'success' => true,
                ], 400);
            });

         }else{
            return response()->json([
                'message' => 'User Not Found',
                'success' => false,
            ], 400);
         }

      

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in AuthController.forgetPassword',
            'error' => $e->getMessage()
        ], 400);
    }

   }

}
    