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
        $endpoint_secret = 'whsec_vxerSUj6Q2RmyozLXcCQWxZ2mHhqXl1W';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

// Handle the event
switch ($event->type) {
  case 'payment_intent.amount_capturable_updated':
    $paymentIntent = $event->data->object;
  case 'payment_intent.canceled':
    $paymentIntent = $event->data->object;
  case 'payment_intent.created':
    $paymentIntent = $event->data->object;
  case 'payment_intent.payment_failed':
    $paymentIntent = $event->data->object;
  case 'payment_intent.processing':
    $paymentIntent = $event->data->object;
  case 'payment_intent.requires_action':
    $paymentIntent = $event->data->object;
  case 'payment_intent.succeeded':
    $paymentIntent = $event->data->object;
  default:
    echo 'Received unknown event type ' . $event->type;
}


       if(isset($paymentIntent->client_secret))
       {
         \Storage::put('stripeResponses/'.$paymentIntent->client_secret.'.json',json_encode($paymentIntent));
       }
       http_response_code(200);
    }

    public function webhookResponse(Request $request)
    {
        $response= \Storage::get('stripeResponses/'.$request->client_secret.'.json');

        return array('status'=>1,'response'=>json_decode($response));
    }


}
