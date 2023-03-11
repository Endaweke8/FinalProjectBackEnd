<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_messages()
    {

    
        try{
            $messagesPerPage = 8;
            $message = Message::orderBy('updated_at', 'desc')
                ->simplePaginate($messagesPerPage);
                $pageCount = count(Message::all()) / $messagesPerPage;
    
            return response()->json([
                'messages' => $message,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in MessageConteroller.get_all_messages',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'messages'=>$user
    ],200);
    }


    
    public function get_all_todaysmessagesreport()
    {

    
        try{
            $date = Carbon::today()->subDays(1);
            $messagesPerPage = 8;
            $message = Message::orderBy('updated_at', 'desc')->where('updated_at', '>=', $date)
                ->simplePaginate($messagesPerPage);
                $pageCount = count(Message::where('updated_at', '>=', $date)->get()) / $messagesPerPage;
    
            return response()->json([
                'messages' => $message,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in MessageConteroller.get_all_messages',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'messages'=>$user
    ],200);
    }


    public function get_total_messages()
    {

    
        try{
         
             $messageCount = count(Message::all());
    
            return response()->json([
                'totalMessages' => $messageCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.get_total_producs',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
        // $user=User::first();
        try{
            $message=Message::create([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'phone'=>$request['phone'],
                'message'=>$request['message'], 
            ]);
            if($message){
            return response()->json([
                'success'=> 'true',
                'message'=>$message
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in MessageController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    public function searchMessage(Request $request){

        
        if($request->searchData){
            $messagesPerPage = 8;
            $searchmessages=Message::orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('email','LIKE','%'.$request->searchData.'%')
            ->orWhere('phone','LIKE','%'.$request->searchData.'%')
            
            
            ->get();

            $searchmessagesCount=Message::orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('email','LIKE','%'.$request->searchData.'%')
            ->orWhere('phone','LIKE','%'.$request->searchData.'%')
            
            
            ->simplePaginate($messagesPerPage);




            $pageCount = count($searchmessages) / $messagesPerPage;




            return response()->json([
                'messages' =>  $searchmessagesCount,
                'page_count' => ceil($pageCount)
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'No search found',
            ]);
        }
       }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $message = Message::findOrFail($id);
            $message->delete();

            return response()->json('message deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in MessageController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
