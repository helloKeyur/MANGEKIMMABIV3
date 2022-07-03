<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Auth;

class PaymentsController extends Controller
{

    public function __construct()
    {
        // $this->apiKey = env('SELCOM_API_KEY');
        // $this->apiSecret = env('SELCOM_API_SECRET');
        // $this->baseURL = env('SELCOM_BASE_URL');
        // $this->vendorId = env('SELCOM_VENDOR_ID');

        $this->apiKey = "UTURN-dt3gtc5sQgbCv8pA";
        $this->apiSecret = "2944a8e6-c981-48e3-9572-66dcc5167245";
        $this->baseURL = "https://apigw.selcommobile.com/v1";
        $this->vendorId = "TILL60613536";
    }

    public function index()
    {
        return redirect('/profile');
    }

    private function computeSignature($params, $signedFields, $requestTimestamp, $apiSecret)
    {
        $fieldsOrder = explode(',', $signedFields);
        $signData = "timestamp=$requestTimestamp";

        foreach ($fieldsOrder as $key) {
            $signData .= "&$key=" . $params[$key];
        }
        return base64_encode(hash_hmac('sha256', $signData, $apiSecret, true));
    }




    private function runRequest($requestBody, $endpointURI, $httpReq)
    {
        $authorization = base64_encode($this->apiKey);
        $timestamp = date('c'); // 2021-06-7T09:30:46+03:00
        $signedFields = implode(',', array_keys($requestBody));
        $digest = $this->computeSignature($requestBody, $signedFields, $timestamp, $this->apiSecret);

        $url = $this->baseURL . $endpointURI;

        $headers = [
            "Content-Type: application/json;charset=\"utf-8\"",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Authorization: SELCOM $authorization",
            "Digest-Method: HS256",
            "Digest: $digest",
            "Timestamp: $timestamp",
            "Signed-Fields: $signedFields",
        ];

        // TO-DO: I'll change this to cURL OOP wrapper later

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($httpReq == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);

        $result = curl_exec($ch);

        $info = curl_getinfo($ch, CURLINFO_HEADER_OUT);

        curl_close($ch);

        return json_decode($result, true);
    }



    public function show($id)
    {

        $endpointURI = "/checkout/order-status?order_id=" . $id;
        $requestBody = [
            "order_id" => $id,
        ];

        $response = $this->runRequest($requestBody, $endpointURI, 'GET');


        if ($response['result'] == 'SUCCESS') {

            if (isset($response['data'][0]['payment_status']) && $response['data'][0]['payment_status'] == "COMPLETED") {

                $Payment =  Payment::where('order_id', $id)->first();
                $val = $response['data'][0]['amount'];
                $user   = User::find($Payment->user_id);

                $PaymentCaluculation = Payment::SubscriptionsCaluculator($user, $val, 'TSH');
                $LastUserSubscriptionCabon = $PaymentCaluculation['SubscriptionStart'];
                $date = $PaymentCaluculation['SubscriptionEnd'];


                if ($Payment) {
                    $Payment->update([
                        'transid' =>  $response['data'][0]['transid'],
                        'channel' => $response['data'][0]['channel'],
                        'result' => $response['result'],
                        'phone' => $response['data'][0]['msisdn'],
                        'amount' => $response['data'][0]['amount'],
                        'payment_status' => $response['data'][0]['payment_status'],
                        'currency' => 'TSH',
                        'start_date' => $LastUserSubscriptionCabon,
                        'end_date' =>  $date
                    ]);
                } else {

                    return response()->json(['error' => "Hatuna malipo haya kwenye record zetu"]);
                }


                return response()->json(['done' => "Malipo yamekamilika. Asante Kwa kujiunga"]);
            } else if (isset($response['data'][0]['payment_status']) && $response['data'][0]['payment_status'] == "PENDING") {

                return response()->json(['pending' => $response['message']]);
            } else {
                return response()->json(['error' => $response['message']]);
            }
        } else {
            return response()->json(['error' => $response['message']]);
        }
    }



    public function get_pending_payments($id)
    {


        $date =  Carbon::now()->subMonth()->timestamp;

        $Payment =  Payment::where('user_id', $id)->where('order_id', '>', $date)->where('channel', '!=', 'PayPal')->where('payment_status', '!=', 'COMPLETED')->get();

        if (count($Payment) > 0) {
            $view = view('frontend.partials.pending_table', ['response' => $Payment])->render();
            return response()->json($view);
        } else {
            return response()->json(false);
        }
    }





    public function payments_filter($time)
    {
        $custom_data = explode('~', $time);
        $from       = $custom_data[0];
        $Upto       = $custom_data[1];

        $endpointURI = "/checkout/list-orders?fromdate={$from}&todate={$Upto}";
        $requestBody = [
            "fromdate" => $from,
            "todate" => $Upto,
        ];

        $response = $this->runRequest($requestBody, $endpointURI, 'GET');

        dd($response);
    }


    private function getOperator($number)
    {
        $shortCode = substr(ltrim($number, $number[0]), 0, 2);

        $shortCodes = [
            'tigo' => ['71', '65', '67'],
            'vodacom' => ['74', '75', '76'],
            'airtel' => ['78', '68', '69'],  //0692747320
            'ttcl' => ['73'],
            'zantel' => ['77'],
            'halotel' => ['61', '62'],
            'smile' => ['66'],
        ];

        $operator = '';

        foreach ($shortCodes as $k => $v) {
            if (in_array($shortCode, $v)) {
                $operator = $k;
                continue;
            }
        }

        return $operator === '' ? 'Unknown Operator' : ucfirst($operator);
    }



    private function generateTransID()
    {
        mt_srand((float) microtime() * 10000);
        $charId = md5(uniqid(rand(), true));
        $c = unpack("C*", $charId);
        $c = implode("", $c);
        return substr($c, 0, 15);
    }




    public function reload_payment_date()
    {

        if (Auth::user()->is_subscribed == "true" && Auth::user()->end_of_subscription_date > \Carbon\Carbon::now()) {
            return response()->json("Mwisho wa kifurushi ni " . \Carbon\Carbon::parse(Auth::user()->end_of_subscription_date)->format('d/m/Y'));
        } else {
            return response()->json(" Huna kifurushi");
        }
    }


    public function complete_payments($time)
    {
        $custom_data = explode('~', $time);
        $vars['from_date'] =  $custom_data[0];
        $vars['to_date'] =  $custom_data[1];
        $vars['time'] =  $time;

        $vars['payments'] = Payment::where('payment_status', 'COMPLETED')->whereBetween("created_at", [Carbon::parse($vars['from_date'])->startOfDay(),  Carbon::parse($vars['to_date'])->endOfDay()])->get();

        return view('v3.backend.payments.index', compact('vars'));
    }



    public function mobile_payments(Request $request)
    {
        $operator = $this->getOperator($request['buyer_phone']);

        if ($operator == 'Vodacom OFFLINe') {
            $response = app('App\Http\Controllers\VodacomMpesaController')->processVodacomPayments($request);

            // $this->processVodacomPayments($request);

            if ($response) {
                return response()->json(['push' => " Tafadhali unlock simu yako na usubiri PIN request."]);
            } else {
                return response()->json(['error' => "Something went wrong"]);
            }
        } else {


            $order_id = time();
            $apiEndpoint = "/checkout/create-order-minimal";


            $req = array(
                "vendor" => $this->vendorId, // Replace with your Vendor TILL No.
                "order_id" => $order_id, //  or generate your own unique order_id
                "buyer_email" =>  $request['buyer_email'],
                "buyer_name" => $request['buyer_name'],   // optional
                "buyer_phone" => $request['buyer_phone'],
                "amount" => $request['amount'],
                "currency" => "TZS",
                "redirect_url" => base64_encode(url('/home')), // Optional
                "cancel_url" => base64_encode(url('/home')), // Optional
                "webhook" => base64_encode(url('/') . "/api/webhock/selcom/{$request['buyer_userid']}"),
                "no_of_items" => 1,
                // "expiry" => 60, // Optional
            );



            $response = $this->runRequest($req, $apiEndpoint, 'POST');

            if ($response['result'] == 'SUCCESS') {
                $Payment = Payment::create([
                    'order_id' => $order_id,
                    'user_id' => $request['buyer_userid'],
                    'reference' => $response['reference'],
                    'resultcode' => $response['resultcode'],
                    'result' => $response['result'],
                    'currency' => 'TSH',
                    'message' => $response['message'],
                    'payment_token' => $response['data'][0]['payment_token'],
                    'payment_gateway_url' => base64_decode($response['data'][0]['payment_gateway_url'])
                ]);

                if ($operator == 'Tigo'  ||  $operator == 'Airtel') {
                    $requestBody = [
                        'transid' => $this->generateTransID(),
                        "order_id" => $order_id,
                        'msisdn' => $request['buyer_phone'],
                    ];
                    $apiEndpoint = "/checkout/wallet-payment";
                    $WalletResponse = $this->runRequest($requestBody, $apiEndpoint, 'POST');
                    $Payment->update([
                        'message' => $WalletResponse['message']
                    ]);

                    return response()->json(['push' => " Tafadhali unlock simu yako na usubiri PIN request."]);
                } else {
                    return response()->json(['done' => base64_decode($response['data'][0]['payment_gateway_url'])]);
                }
            } else {
                return response()->json(['error' => $response['result'] . ' ' . $response['message']]);
            }
        }
    }

    public function card_payments(Request $request)
    {

        $order_id = time();
        $apiEndpoint = "/checkout/create-order";


        $req = array(
            "vendor" => $this->vendorId, // Replace with your Vendor TILL No.
            "order_id" => $order_id, //  or generate your own unique order_id
            "buyer_email" => $request['buyer_email'],
            "buyer_name" => $request['firstname'] . " " . $request['lastname'],
            "buyer_userid" => $request['buyer_userid'],   // optional
            "buyer_phone" => $request['buyer_phone'],
            "amount" => $request['amount'],
            "currency" => "TZS",
            "payment_methods" => "CARD", // Choose one preferred method or ALL
            "redirect_url" => base64_encode(url('/home')), // Optional
            "cancel_url" => base64_encode(url('/home')), // Optional
            "webhook" => base64_encode(url('/') . "/api/webhock/selcom/{$request['buyer_userid']}"),
            "billing.firstname" => $request['firstname'],
            "billing.lastname" => $request['lastname'],
            "billing.address_1" => "Mwenge Dar es Salaam",
            "billing.city" => "Dar es Salaam",
            "billing.state_or_region" => "Dar es Salaam",
            "billing.postcode_or_pobox" => "11530",
            "billing.country" => "TZ",
            "billing.phone" => $request['buyer_phone'],
            "no_of_items" => 1,
            // "expiry" => 60, // Optional
        );

        $response = $this->runRequest($req, $apiEndpoint, 'POST');


        if ($response['result'] == 'SUCCESS') {
            $Payment = Payment::create([
                'order_id' => $order_id,
                'user_id' => $request['buyer_userid'],
                'reference' => $response['reference'],
                'resultcode' => $response['resultcode'],
                'result' => $response['result'],
                'currency' => 'TSH',
                'message' => $response['message'],
                'gateway_buyer_uuid' => $response['data'][0]['gateway_buyer_uuid'],
                'payment_token' => $response['data'][0]['payment_token'],
                'qr' => $response['data'][0]['qr'],
                'payment_gateway_url' => base64_decode($response['data'][0]['payment_gateway_url'])
            ]);


            return response()->json(['done' => base64_decode($response['data'][0]['payment_gateway_url'])]);
        } else {
            return response()->json(['error' => $response['result'] . ' ' . $response['message']]);
        }
    }


    public function destroy($id)
    {
        $Payment = Payment::find($id);
        $Payment->update(['deleted_by_id', Auth::user()->id]);
        $Payment->delete();
        return \Response::Json('Delete Success', 200);
    }
}