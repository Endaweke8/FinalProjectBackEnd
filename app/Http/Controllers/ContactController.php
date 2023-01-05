<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required'
        ]);
      
           $mail_data=[
            'recipient'=>'endaweke1234@gmail.com',
            'fromEmail'=>$request->email,
            'fromName'=>$request->name,
            'subject'=>$request->subject,
            'body'=>$request->message,
           ];
           \Mail::send('email-template',$mail_data,function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
            ->from($mail_data['fromEmail'],$mail_data['fromName'])
            ->subject($mail_data['subject']);
           });

           return redirect()->back()->with('success',"Email Sent successfuly");

            return "Connected";


        }
    
    }
  

