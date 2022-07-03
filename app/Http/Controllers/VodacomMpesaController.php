<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Subscriber;
use App\Vodacom\APIContext;
use App\Vodacom\APIRequest;
use App\Vodacom\APIMethodType;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Payment;

class VodacomMpesaController extends Controller {
    
    public function __construct() {
        // $this->middleware('auth');
    }
    
    public function index() {

        // $requestBody = $request->all();

        $payload = file_get_contents('php://input');
        $request = json_decode($payload, false);

        if (!isset($request->order_id) || empty($request->order_id)) {
            return response()->json([
                'error' => 'Invalid payload.'
            ]);
        }

        $res = $this->run($request);
        \Log::debug(print_r($res));

        // if ($res->output_ResponseCode = "INS-0") {}
        
    }


    public function processVodacomPayments($request){
    $order_id = time();
        $reqArray = array(
        "order_id" => $order_id,
        "phone" => $request['buyer_phone'], //$request['buyer_phone']
        "amount" => $request['amount'],  //$request['amount']
         "platform" => 'Web', 
    );

        $req = (object) $reqArray;
        if (!isset($req->order_id) || empty($req->order_id)) {
         
            return response()->json([
                'error' => 'Invalid payload.'
            ]);
        }


        $res = $this->run($req);


        Payment::create([
                    'order_id' => $order_id,
                    'channel' => 'Vodacom',
                    'currency' => "TSH",
                    'phone' => $request['buyer_phone'],
                    'user_id' => $request['buyer_userid'],
                   ]);
        return response()->json(true);
        // \Log::debug(print_r($res));
    }

    private function run($req) {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $context = new APIContext();
        $context->set_method_type(APIMethodType::GET);
        $context->set_address('openapi.m-pesa.com');
        $context->set_port(443);
        $context->set_path('/openapi/ipg/v2/vodacomTZN/getSession/');
        $context->add_header('Origin', '3.144.216.126');

        $request = new APIRequest($context);
        $response = null;

        try {
            $response = $request->execute();
        } catch(exception $e) {
	        echo 'Call failed: ' . $e->getMessage() . '<br>';
        }

        if ($response->get_body() == null) {
            throw new Exception('SessionKey call failed to get result. Please check.');
        }

        Log::debug(print_r($response, true));

        $decoded = json_decode($response->get_body());

        $context = new APIContext();

        $msisdn = '255' . ltrim($req->phone, $req->phone[0]);
        
        $context->set_api_key($decoded->output_SessionID);
        $context->set_ssl(true);
        $context->set_method_type(APIMethodType::POST);
        $context->set_address('openapi.m-pesa.com');
        $context->set_path('/openapi/ipg/v2/vodacomTZN/c2bPayment/singleStage/');
        $context->add_header('Origin', '*');

        $third_party_conversation_id = $this->generateConversationID();

        $context->add_parameter('input_Amount', strval($req->amount));
        $context->add_parameter('input_Country', 'TZN');
        $context->add_parameter('input_Currency', 'TZS');
        $context->add_parameter('input_CustomerMSISDN', strval($msisdn));
        $context->add_parameter('input_ServiceProviderCode', '971885');
        $context->add_parameter('input_ThirdPartyConversationID', $third_party_conversation_id);
        $context->add_parameter('input_TransactionReference', strtoupper($this->generateTransactionRef()));
        $context->add_parameter('input_PurchasedItemsDesc', 'usajili wa Mange Kimambi App');

        $subscriber = new Subscriber;
        $subscriber->name = 'A Z'; // $req->subscriber_first_name . ' ' . $req->subscriber_last_name;
        $subscriber->msisdn = $req->phone;
        $subscriber->third_party_conversation_id = $third_party_conversation_id;
        $subscriber->transaction_reference = strval($req->order_id);
        $subscriber->amount = strval($req->amount);
        $subscriber->user_id = '';
        $subscriber->duration = 1;
        $subscriber->order_id = $req->order_id;
        $subscriber->fcm_token = '';
        $subscriber->device = !isset($request->device) || empty($request->device) ? 'unspecified' : $request->device;
        $subscriber->app_version = !isset($request->app_version) || empty($request->app_version) ? 'unspecified' : $request->app_version;
        $subscriber->save();

        $request = new APIRequest($context);

        sleep(5);

        $response = null;

        try {
	        $response = $request->execute();
        } catch(exception $e) {
	        echo 'Call failed: ' . $e->getMessage() . '<br>';
        }

        if ($response->get_body() == null) {
	        throw new Exception('API call failed to get result. Please check.');
        }

        $decoded = json_decode($response->get_body());

        return $decoded;

        // if ($decoded->output_ResponseCode != "INS-0") \Log::debug(print_r($response, true));

        
    }
    
    private function generateConversationID() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
      
        for ($i = 0; $i < 25; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
      
        return $randomString;
    }

    private function generateTransactionRef($length = 10) {
        if ($length < 1) $length = 1;
        return substr(preg_replace("/[^A-Za-z0-9]/", '', base64_encode(openssl_random_pseudo_bytes($length * 2))), 0, $length);
    }

    public function getCallback() {
        $payload = file_get_contents('php://input');
        $response = json_decode($payload, true);


        // Log::debug('Nakamoli');

         // Log::debug(print_r($response, true));
        $subscriber = Subscriber::where('third_party_conversation_id', '=', $response['input_ThirdPartyConversationID'])->first();
       
        $headers  = ['Content-Type: application/json;charset=UTF-8', 'Accept: application/json'];
        $request = [];
        $request['order_id'] = $subscriber->order_id;
        $request['phone'] = $subscriber->msisdn;
        $request['status'] = $response['input_ResultCode'] != 'INS-0' ? 'FAIL' : 'SUCCESS';
        $request['reference'] = $subscriber->third_party_conversation_id;
        $request['paid_amount'] = $subscriber->amount;
        $request['message'] = $response['input_ResultDesc'];
        
        if ($response['input_ResultCode'] == 'INS-0') $subscriber->status = 1;
        $subscriber->message = $response['input_ResultDesc'];
        $subscriber->save();
     
   
         $Payment =  Payment::where('order_id',$request['order_id'])->first();

       if($request['status'] == 'SUCCESS'){

        $val = $request['paid_amount'];
        $user   = User::find($Payment->user_id);
        $PaymentCaluculation = Payment::SubscriptionsCaluculator($user,$val,'TSH');
        $LastUserSubscriptionCabon = $PaymentCaluculation['SubscriptionStart'];
        $date = $PaymentCaluculation['SubscriptionEnd'];
    
        

         if($Payment){
                $Payment->update([
                            'reference' => $request['reference'],
                            'channel' => 'Vodacom',
                            'result' => $request['status'],
                            'phone' => $request['phone'],
                            'currency' => "TSH",
                            'amount' => $request['paid_amount'],
                            'payment_status' => $request['status'] == "SUCCESS"? "COMPLETED":"PENDING",
                            'start_date' => $LastUserSubscriptionCabon,
                            'end_date' =>  $date
                   ]);
             }else{
                $Payment = Payment::create([
                            'user_id' => $user->id,
                            'reference' => $request['reference'],
                            'channel' => 'Vodacom',
                            'currency' => "TSH",
                            'result' => $request['status'],
                            'phone' => $request['phone'],
                            'amount' => $request['paid_amount'],
                            'payment_status' => $request['status'] == "SUCCESS"? "COMPLETED":"PENDING",
                            'start_date' => $LastUserSubscriptionCabon,
                            'end_date' =>  $date
                   ]);
             }


                   
         }else{

            if($Payment){
                $Payment->update([
                            'reference' => $request['reference'],
                            'channel' => 'Vodacom',
                            'result' => $request['status'],
                            'phone' => $request['phone'],
                            'amount' => $request['paid_amount'],
                            'message' => $request['message'],
                            'payment_status' => $request['status'],
                   ]);
             }else{
               
             }


         
        }

       return response()->json(200);




       //  $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "http://3.145.130.41/api/webhock/vodacom_calback");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));           
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // $result     = curl_exec ($ch);
        // $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Log::debug($result . "Status Code " . $statusCode);
        // curl_close($ch);
       //  if ($response['input_ResultCode'] == 'INS-0') $subscriber->delete();
    }

    public function getStatus($user_id,$orderId) {

        $subscriber = Subscriber::where('order_id', '=', $orderId)->first();


        if (!$subscriber) return response()->json(['error' => 'Muamala Huu  haupo.']);
        $request = [];
        $request['order_id'] = $subscriber->order_id;
        $request['phone'] = $subscriber->msisdn;
        $request['status'] = $subscriber->status ? 'SUCCESS' : 'FAIL';
        $request['reference'] = $subscriber->transaction_reference;
        $request['paid_amount'] = $subscriber->amount;
        $request['message'] = $subscriber->message;

        $Payment =  Payment::where('order_id',$orderId)->where('user_id',$user_id)->first();
             if($request['status'] == 'SUCCESS'){

        $val = $request['paid_amount'];
         $user  = User::find($user_id);
      $PaymentCaluculation = Payment::SubscriptionsCaluculator($user,$val,'TSH');
       $LastUserSubscriptionCabon = $PaymentCaluculation['SubscriptionStart'];
       $date = $PaymentCaluculation['SubscriptionEnd'];
    
        // if(isset($user->end_of_subscription_date)){
        //     $LastUserSubscriptionCabon = Carbon::parse($user->end_of_subscription_date);
        // }else{
        //     $LastUserSubscriptionCabon =  Carbon::now();
        // }
        // if($val == 1000){
        //     $date = $LastUserSubscriptionCabon->addMonth();
        // }else if($val == 3000){
        //      $date = $LastUserSubscriptionCabon->addMonths(3);
        // }else if($val == 5000){
        //      $date = $LastUserSubscriptionCabon->addMonths(6);
        // }else if($val == 10000){
        //     $date = $LastUserSubscriptionCabon->addMonths(12);
        // }else{
        //     $date = $LastUserSubscriptionCabon->addMonth();
        // }

        //   $user->update([
        //     'end_of_subscription_date' => $date,
        //     'is_subscribed' => true
        //     ]);

         if($Payment){
                $Payment->update([
                            'reference' => $request['reference'],
                            'channel' => 'Vodacom',
                            'result' => $request['status'],
                            'phone' => $request['phone'],
                            'amount' => $request['paid_amount'],
                            'payment_status' => $request['status'] == "SUCCESS"? "COMPLETED":"PENDING",
                            'start_date' => $LastUserSubscriptionCabon,
                            'end_date' =>  $date
                   ]);
             }else{
                // $Payment = Payment::create([
                //             'user_id' => $user->id,
                //             'reference' => $request['reference'],
                //             'channel' => 'Vodacom',
                //             'result' => $request['status'],
                //             'phone' => $request['phone'],
                //             'amount' => $request['paid_amount'],
                //             'payment_status' => $request['status'] == "SUCCESS"? "COMPLETED":"PENDING",
                //             'start_date' => $LastUserSubscriptionCabon,
                //             'end_date' =>  $date
                //    ]);
             }

             return response()->json(['done' => "Malipo yamekamilika. Asante Kwa kujiunga"]);      
         
         }else{
        
           $Payment->update([
                            'reference' => $request['reference'],
                            'channel' => 'Vodacom',
                            'result' => $request['status'],
                            'phone' => $request['phone'],
                            'amount' => $request['paid_amount'],
                            'message' => $request['message'],
                            'payment_status' => $request['status'],
                   ]);

         return response()->json(['error' => $request['message']]);
         
        }


    } 
}
