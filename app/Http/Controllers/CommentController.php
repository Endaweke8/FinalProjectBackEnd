<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        try{
            $comment=Comment::create([
                'comment'=>$request['comment'],
                'product_id'=>$request['product_id'],
                'user_id'=>$request['user_id'],
                'user_name'=>$request['user_name'],
                'userimage'=>$request['userimage'],
                
            ]);
            if($comment){
            return response()->json([
                'success'=> 'true',
                'comment'=>$comment
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CommentController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['image' => $user->image], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CommentController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function showName(int $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['name' => $user->first_name], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CommentController.showName',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, int $id)
    {
        try {
            $comment = Comment::findOrFail($id);





            $comment->comment=$request['comment'];
            $comment->product_id=$request['product_id'];
            $comment->user_id=$request['user_id'];
            $comment->user_name=$request['user_name'];
            $comment->userimage=$request['userimage'];


            $comment->save();

            return response()->json('Comment  Edited', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CommentController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $comment = Comment::where('id',$id);
            $comment->delete();

            return response()->json('comment deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CommentController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
