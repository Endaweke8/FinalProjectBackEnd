<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    
    {

      
        $user = User::findOrFail($id);
    
      if(!$request->get('product_id')){

        return [
            'message'=>'Bookmark items returned',
            'items'=>Bookmark::where('user_id',$user->id)->sum('quantity'),
            'users'=>$user,

        ];

      }

    //   if($request->get('product_id')){

    //     return [
    //         'message'=>'Bookmark items already exsist',
    //         'items'=>Bookmark::where('user_id',$user->id)->sum('quantity'),
    //         'users'=>$user,

    //     ];

    //   }



      $userItems=Bookmark::where('user_id',$user->id)->sum('quantity');
      
      $product=Product::where('id', $request->get('product_id'))->first();

      $productFoundInBookmark=Bookmark::where('product_id',$request->get('product_id'))->pluck('id');
    //   return response()->json($productFoundInCart->isEmpty());

  

      if($productFoundInBookmark->isEmpty()){
    
        $bookmark= Bookmark::create([
            'product_id'=>$product->id,
            'quantity'=>1,
            
            'user_id'=>$user->id,
          ]);

      }
      else{

        return response()->json([
            'message'=>"item is already exsist",
            'items'=>Bookmark::where('user_id',$user->id)->sum('quantity'),
        ]);
        // $bookmark=Bookmark::where('product_id',$request->get('product_id'))->increment('quantity');

      }

     
      if($bookmark){
        return [
            'message'=>'Bookmark Updated',
            'items'=>Bookmark::where('user_id',$user->id)->sum('quantity'),
            'users'=>$user->id,
            'user'=>$user

        ];
      }

      return response()->json([
        'product'=>$product,
        'user'=>$user

      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $quant=Bookmark::where('user_id',$user->id)->sum('quantity');
            $bookmarkwithid=Bookmark::where('user_id',$user->id)->get();
       $bookmarkItems=Bookmark::with('product')->where('user_id',$user->id)->get();
       $finalData=[];
     
       
      if(isset($bookmarkItems)){

       
        foreach($bookmarkItems as $bookmarkItem){
         if($bookmarkItem->product){
         
          
          foreach($bookmarkItem->product as $bookmarkProduct){
          if($bookmarkProduct->id==$bookmarkItem->product_id){
           
            $finalData[$bookmarkItem->product_id]['id']=$bookmarkProduct->id;
            $finalData[$bookmarkItem->product_id]['name']=$bookmarkProduct->name;
            $finalData[$bookmarkItem->product_id]['image_name']=$bookmarkProduct->image_name;
            $finalData[$bookmarkItem->product_id]['quantity']=$bookmarkItem->quantity;
            $finalData[$bookmarkItem->product_id]['sale_price']=$bookmarkProduct->sale_price;
            $finalData[$bookmarkItem->product_id]['price']=$bookmarkProduct->price;
            $finalData[$bookmarkItem->product_id]['category']=$bookmarkProduct->category;
            $finalData[$bookmarkItem->product_id]['subcategory']=$bookmarkProduct->subcategory;
            $finalData[$bookmarkItem->product_id]['subcategory1']=$bookmarkProduct->subcategory1;

            // $amount+=$bookmarkItem->price*$bookmarkItem->quantity;
            // $finalData['totalAmount']=$amount;

          }
         
          }

         }
        }
       

      }

     
      return response()->json(
    [

      'bookmark'=>$bookmarkwithid,
      'bookmarkwithproduct'=>$finalData,
      'quantity'=>$quant,
    ]
    ,200
    );

          
            // return response()->json([
            //   'cart'=>$cart,
            //    'quantity'=>$quant,
            // ],200)
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in Bookmark.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $bookmark = Bookmark::where('product_id',$id);
            $bookmark->delete();

            return response()->json('Bookmark deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in BookmarkController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function ClearBookmarks(int $id)
    {
        try {
            $user = User::findOrFail($id);
            Bookmark::where('user_id',$user->id)->delete();
            

            return response()->json([
              'success'=>'Bookmark deleted Sucessfuly',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in BookmarkController.clearbookmarks',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
