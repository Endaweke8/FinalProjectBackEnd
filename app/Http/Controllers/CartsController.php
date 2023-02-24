<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Processing;
use Illuminate\Http\Request;
use App\Notifications\ProductNotification;
use Illuminate\Support\Facades\Notification;

class CartsController extends Controller
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
        $num=$id;
      if(!$request->get('product_id')){

        return [
            'message'=>'Cart items returned',
            'items'=>Cart::where('user_id',$num)->sum('quantity'),
            'users'=>$user,

        ];

      }




      $userItems=Cart::where('user_id',$user->id)->sum('quantity');
      
      $product=Product::where('id', $request->get('product_id'))->first();

      $productFoundInCart=Cart::where('product_id',$request->get('product_id'))->pluck('id');
    //   return response()->json($productFoundInCart->isEmpty());

  

      if($productFoundInCart->isEmpty()){
    
        $cart= Cart::create([
            'product_id'=>$product->id,
            'quantity'=>1,
            'price'=>$product->sale_price,
            'user_id'=>$user->id,
          ]);

      }
      else{

        $cart=Cart::where('product_id',$request->get('product_id'))->increment('quantity');

      }

     
      if($cart){
        return [
            'message'=>'Cart Updated',
            'items'=>Cart::where('user_id',$user->id)->sum('quantity'),
            'users'=>$user->id,

        ];
      }

      return response()->json($product);
    }



    public function RemoveFromCart(Request $request)
    
    {

     

      if(!$request->get('product_id')){

        return [
            'message'=>'Cart items returned',
            // 'items'=>Cart::where('user_id','1')->sub('quantity'),

        ];

      }




      // $userItems=Cart::where('user_id','1')->sub('quantity');
      
      $product=Product::where('id', $request->get('product_id'))->first();

      $productFoundInCart=Cart::where('product_id',$request->get('product_id'))->get();
    //   return response()->json($productFoundInCart->isEmpty());

  

      if($productFoundInCart->isEmpty()){
        return [
          'message'=>'The Cart is Empity',

      ];

      }
      else{

        $cart=Cart::where('product_id',$request->get('product_id'))->decrement('quantity');

      }

     
      if($cart){
        return [
            'message'=>'Cart Updated',
            'quantity'=>$productFoundInCart,
            // 'items'=>Cart::where('user_id','1')->sub('quantity'),

        ];
      }

      return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $quant=Cart::where('user_id',$user->id)->sum('quantity');
            $cartwithid=Cart::where('user_id',$user->id)->get();
       $cartItems=Cart::with('product')->where('user_id',$user->id)->get();
       $finalData=[];
       $amount=0;
       
      if(isset($cartItems)){

       
        foreach($cartItems as $cartItem){
         if($cartItem->product){
         
          
          foreach($cartItem->product as $cartProduct){
          if($cartProduct->id==$cartItem->product_id){
           
            $finalData[$cartItem->product_id]['id']=$cartProduct->id;
            $finalData[$cartItem->product_id]['name']=$cartProduct->name;
            $finalData[$cartItem->product_id]['image_name']=$cartProduct->image_name;
            $finalData[$cartItem->product_id]['quantity']=$cartItem->quantity;
            $finalData[$cartItem->product_id]['sale_price']=$cartItem->price;
            $finalData[$cartItem->product_id]['total']=$cartItem->price*$cartItem->quantity;
            $amount+=$cartItem->price*$cartItem->quantity;
            $finalData['totalAmount']=$amount;

          }
         
          }

         }
        }
       

      }

     
      return response()->json(
    [

      'cart'=>$cartwithid,
      'cartwithproduct'=>$finalData,
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
                'message' => 'Something went wrong in CartController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getCart(int $id)
    {
        try {
           
            $quant=Cart::where('product_id',$id)->sum('quantity');

      return response()->json(
    [
      'cartQuantity'=>$quant,
    ]
    ,200
    );

   
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CartController.getCart',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    public function getCartItemsForCheckout(int $id){
      $user=User::findOrFail($id);
      $cartItems=Cart::with('product')->where('user_id',$user->id)->get();
       $finalData=[];
       $amount=0;
       
      if(isset($cartItems)){

       
        foreach($cartItems as $cartItem){
         if($cartItem->product){
         
          
          foreach($cartItem->product as $cartProduct){
          if($cartProduct->id==$cartItem->product_id){
           
            $finalData[$cartItem->product_id]['id']=$cartProduct->id;
            $finalData[$cartItem->product_id]['name']=$cartProduct->name;
            $finalData[$cartItem->product_id]['image_name']=$cartProduct->image_name;
            $finalData[$cartItem->product_id]['quantity']=$cartItem->quantity;
            $finalData[$cartItem->product_id]['sale_price']=$cartItem->price;
            $finalData[$cartItem->product_id]['total']=$cartItem->price*$cartItem->quantity;
            $amount+=$cartItem->price*$cartItem->quantity;
            $finalData['totalAmount']=$amount;

          }
         
          }

         }
        }
       

      }

     
      return response()->json(
    [
      'resdata'=>$finalData,
      "users"=>$user->id
    ]
    );

    
    }

    public function processPayment(Request $request){
    
        $user=User::where('id', $request->get('user_id'))->first();
        $firstName=$request->get('firstName');
        $lastName=$request->get('lastName');
        $address=$request->get('address');
        $city=$request->get('city');
        $country=$request->get('country');
        $phone=$request->get('phone');
        $email=$request->get('email');
        $zipCode=$request->get('zipCode');
        $cardType=$request->get('cardType');
        $cardNumber=$request->get('cardNumber');
        $cvv=$request->get('cvv');
        $expirationMonth=$request->get('expirationMonth');
        $expirationYear=$request->get('expirationYear');
        $state=$request->get('state');
        $amount=$request->get('amount');
        $orders=$request->get('order');

      //   $ordersArray=[];

      // foreach($orders as $order){

        
      //   if($order['id']){
      //     $ordersArray[$order['id']]['order_id']=$order['id'];
      //     $ordersArray[$order['id']]['quantity']=$order['quantity'];
      //   }
      // }

      // dd($order,$ordersArray);
      
        //Processing Payment
        
      try {
        $stripe=Stripe::make(env('STRIPE_KEY'));
      
        $token=$stripe->tokens()->create([
         'card'=>[
          'number'=>$cardNumber,
          'exp_month'=>$expirationMonth,
          'exp_year'=>$expirationYear,
          'cvc'=>$cvv,
         ]
        ]); 
         
       if(!$token['id']){
        session()->flush('error','Stripe token generation failed');
        return;
       }
  
        $customer=$stripe->customers()->create([
          'name'=>$firstName.''.$lastName,
          'email'=>$email,
          'phone'=>$phone,
          'address'=>[
            'line1'=>$address,
            'postal_code'=>$zipCode,
            'city'=>$city,
            'state'=>$state,
            'country'=>$country,
          ],
          'shipping'=>[
            'name'=>$firstName.''.$lastName,
            'address'=>[
              'line1'=>$address,
              'postal_code'=>$zipCode,
              'city'=>$city,
              'state'=>$state,
              'country'=>$country,
            ],
          ],
          'source'=>$token['id'],
        ]);
       

        //Code for charging the client in Stripe

        $charge=$stripe->charges()->create([
          'customer'=>$customer['id'],
          'currency'=>'USD',
          'amount'=>$amount,
          'description'=>'Payment for order',
        ]);


        if($charge['status']=='succeeded'){

          $customerIdStrip=$charge['id'];
          $amountRec=$charge['amount'];
          

      $processingDetails= Processing::create([
                 'client_id'=>$user->id,
                 'client_name'=>$firstName.'   '.$lastName,
                 'client_address'=>json_encode([
                                    'line1'=>$address,
                                    'postal_code'=>$zipCode,
                                    'city'=>$city,
                                    'state'=>$state,
                                    'country'=>$country,
                 ]),
                 'order_details'=>json_encode($orders),
                 'amount'=>$amount,
                 'currency'=>$charge['currency'],
          ]);

          if($processingDetails){
            $user=User::first();
            $message="Orders Product";
            Notification::send($user,new ProductNotification($firstName,$message));
          

            Cart::where('user_id',$user->id)->delete();


            return [
              'success'=>'Order Completed Sucessfuly',
              'client-id'=>$user
            ];
          }
          else{
            return['error'=>'Order failed Contact Support'];
            
          }

        }
      }catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in CartController.processPayment',
            'errors' => $e->getMessage()
        ], 400);
    }
       
    }

    



    public function DestroyCartAterPayment(int $id)
    {
        try {
            $user = User::findOrFail($id);
            Cart::where('user_id',$user->id)->delete();
            

            return response()->json([
              'success'=>'Cart deleted Sucessfuly',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CartsController.ClearCartItems',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function clearCartItem(int $id)
    {
        try {
            $user = User::findOrFail($id);
            Cart::where('user_id',$user->id)->delete();
            

            return response()->json([
              'success'=>'Cart deleted Sucessfuly',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CartsController.ClearCartItems',
                'error' => $e->getMessage()
            ], 400);
        }
    }
 

    public function destroy(int $id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();

            return response()->json('Cart deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CartController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }



    // public function clearCartItem(){
    //   Cart::where('user_id','2')->delete();
    //   return [
    //     'success'=>'Cart deleted Sucessfuly'
    //   ];
    // }

}
