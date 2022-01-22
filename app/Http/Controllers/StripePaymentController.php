<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    protected $stripeClient;
    protected $amount=0;

    public function __construct()
    {
        $this->stripeClient=config('STRIPE_TEST_CLIENT',env('STRIPE_TEST_CLIENT'));

    }

    public function index()
    {
       
        return view('stripe.index')->with('indent');
    }


    public function success()
    {
        return view('stripe.success');
    }

    public function createPaymentIndent(Request $request)
    {
        

         if(isset($request->stripeClient) && $request->stripeClient)
         {
            $this->stripeClient=$request->stripeClient;
         }

          $this->amount=intval($request->amount);

         try {
              
       
        $stripe = new \Stripe\StripeClient($this->stripeClient);

        $intent=$stripe->paymentIntents->create([
                                                 'amount' => $this->amount,
                                                 'currency' => 'usd',
                                                 
                                               ]);

        \Storage::put('stripeResponses/'.$intent['client_secret'].'.json','randeep singh');
       
         $resoponse=array('status'=>1,'message'=>'Intent Created','client_secret'=>$intent['client_secret']);

         } catch (\Stripe\Exception\InvalidRequestException $e) {

            
          
            $resoponse=array('status'=>0,'message'=>$e->getMessage());
              
          }

          return $resoponse;

        
    }

    public function webhook(Request $request)
    {
       if(isset($request->object->client_secret))
       {
         \Storage::put('stripeResponses/'.$request->object->client_secret.'.json',json_encode($request->object));
       }
    }

    public function webhookResponse(Request $request)
    {
        $response= \Storage::get('stripeResponses/'.$request->client_secret.'.json');

        return array('status'=>1,'response'=>$response);
    }
}
