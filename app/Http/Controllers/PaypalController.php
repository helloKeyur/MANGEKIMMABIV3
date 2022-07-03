<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
   


public function processPaypal(Request $request)
{

  
    $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('processSuccess'),
                "cancel_url" => route('processCancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->amount
                        
                    ],
                    "description"=>\Auth::id()
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    Payment::create([
                    'order_id' => time(),
                    'reference' => $response['id'],
                    'channel' => 'PayPal',
                    'amount' => $request->amount,
                    'currency' => "USD",
                    'phone' => \Auth::user()->phone,
                    'user_id' => \Auth::id(),
                   ]);
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('home')
                ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->route('home')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
}


public function processSuccess(Request $request)
{



        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);



        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
        $Payment =  Payment::where('reference',$response['id'])->where('channel','PayPal')->first();


        $val = $Payment->amount;
        $user   = User::find($Payment->user_id);

        $PaymentCaluculation = Payment::SubscriptionsCaluculator($user,$val,'USD');
        $LastUserSubscriptionCabon = $PaymentCaluculation['SubscriptionStart'];
        $date = $PaymentCaluculation['SubscriptionEnd'];
    
        // if(isset($user->end_of_subscription_date)){
        //     $LastUserSubscriptionCabon = Carbon::parse($user->end_of_subscription_date);
        // }else{
        //     $LastUserSubscriptionCabon =  Carbon::now();
        // }
        // if($val == '1.00'){
        //     $date = $LastUserSubscriptionCabon->addMonth();
        // }else if($val == '2.00'){
        //      $date = $LastUserSubscriptionCabon->addMonths(3);
        // }else if($val == '5.00'){
        //      $date = $LastUserSubscriptionCabon->addMonths(6);
        // }else if($val == '10.00'){
        //     $date = $LastUserSubscriptionCabon->addMonths(12);
        // }

        //  $user->update([
        //                 'end_of_subscription_date' => $date,
        //                 'is_subscribed' => true
        //                 ]);

         if($Payment){
                $Payment->update([
                            'result' => 'COMPLETED',
                            'payment_status' => "COMPLETED",
                            'start_date' => $LastUserSubscriptionCabon,
                            'end_date' =>  $date
                   ]);
             }




            return redirect()
                ->route('home')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('home')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }

}

 public function processCancel(Request $request)
    {
        return redirect()
            ->route('home')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

}