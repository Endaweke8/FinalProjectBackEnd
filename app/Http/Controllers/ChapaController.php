<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\User;
use App\Models\Processing;
use Illuminate\Http\Request;
use Chapa\Chapa\Facades\Chapa as Chapa;

class ChapaController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    protected $reference;

    public function __construct(){
        $this->reference = Chapa::generateReference();

    }
    public function initialize(Request $request)
    {
        
        //This generates a payment reference
        $reference = $this->reference;
        

        // Enter the details of the payment
        $data = [
            
            'amount' =>$request->amount,
            'email' => 'endaweke1234@gmail.com',
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => route('callback',[$reference]),
            'first_name' => "Endaweke",
            'last_name' => "Enkuahone",
            "customization" => [
                "title" => 'Chapa Testtttt',
                "description" => "I testtsteee this",
                
            ]
        ];
       
        // return response()->json($data);     
   
        $payment = Chapa::initializePayment($data);
      
        if ($payment['status'] !== 'success') {
         
            return response()->json([
                'error'=>'Error',
            ]);
 
        }
        return response()->json([
            'data'=>$data,
            'payment'=>$payment
        ]); 

        // return redirect($payment['data']['checkout_url']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback($reference)
    {
        
        $data = Chapa::verifyTransaction($reference);
         
        //if payment is successful
        if ($data['status'] ==  'success') {

            return response()->json([
                'data'=>$data,
                'payment'=>$data
            ]); 
        }

        else{
            //oopsie something ain't right.
        }


    }


    public function processPayment(Request $request){
        try {
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
        $shipping_birr=$request->get('shipping_birr');

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
                 'shipping_birr'=>$shipping_birr,
                 'amount'=>$amount,
                 'total_buying_price'=>$request->total_buying_price,
                 'profit'=>$amount-$request->total_buying_price,
                 'payment_method'=>'chapa',
                 'card_no'=>$cardNumber,
                 'currency'=>"birr",
          ]);

          if($processingDetails){
            // $user=User::first();
            // $message="Orders Product";
            // Notification::send($user,new ProductNotification($firstName,$message));
          

            Cart::where('user_id',$user->id)->delete();


            return response()->json( [
              'success'=>'Order Completed Sucessfuly',
              'client-id'=>$user
            ]);
          }
          else{
            return['error'=>'Order failed Contact Support'];
            
          }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ChapaController.paymentProcessing',
                'errors' => $e->getMessage()
            ], 400);
        }

        

       
    }

    
}