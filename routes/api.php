
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Payment;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/








// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {

    Route::group(['middleware' => ['responsekey']], function () {


      Route::post('/login', 'ApiUserController@login');
      Route::post('/password_recovery', 'ApiUserController@password_recovery');
      Route::post('/register', 'ApiUserController@RegisterTwo');
      Route::get('/verify_username/{name}', 'ApiUserController@verifyUsername');




      Route::middleware('auth:api')->group(function () {
            Route::get('/get_data', 'ApiUserController@getData');
            Route::get('/refresh_last_payment', 'ApiUserController@refreshLastPayment');
            Route::post('/update_my_email', 'ApiUserController@updateMyEmail');
            Route::get('/get_web_url', 'ApiUserController@getwebUrl');
            Route::post('/add_email_for_user', 'ApiUserController@addEmailForUser');
            Route::post('/add_verification_for_user', 'ApiUserController@addVerificationForUser');
            // Route::get('/delete_user/{id}', 'ApiUserController@deleteUser');
            Route::get('/get_user_data/{id}', 'ApiUserController@get_user_data');
            Route::post('/search_post', 'ApiPostController@search_post');
            Route::get('/get_app_info', 'ApiUserController@getAppInfo');
            Route::post('/submit_notification_token', 'ApiUserController@submitNotificationToken');
            Route::get('/get_emoj', 'ApiPostController@getEmoj');
            Route::get('/post_viewer/{post_id}', 'ApiPostController@postViewer');
            Route::get('/get_food/{date}', 'ApiPostController@getFood');
            Route::get('/get_workout/{date}', 'ApiPostController@getWorkout');
            Route::get('/submit_user_screenshots', 'ApiUserController@submitUserScreenshots');
            Route::post('/update_user', 'ApiUserController@updateUser');
            Route::post('/user_support', 'ApiUserController@userSupport');
            Route::post('/submit_likes', 'ApiPostController@submitLikes');
            Route::post('/submit_comment', 'ApiPostController@submitComment');
            Route::get('/get_post_comments/{id}', 'ApiPostController@getPostComments');
            Route::get('/get_all_post/{from}/{to}/{limit}', 'ApiPostController@getPost');
            Route::get('/get_all_video/{from}/{to}/{limit}', 'ApiPostController@getAllVideo');
            Route::get('/get_all_post_by_categories/{from}/{to}/{limit}/{category_id}', 'ApiPostController@getAllPostByCategories');
            Route::get('/get_categories', 'ApiPostController@getCategories');
            Route::post('/change_password', 'ApiUserController@change_password');
            Route::get('/get_post_by_id/{id}', 'ApiPostController@getPostById');
            Route::get('/get_post_custom/{id}/{category_id}/{status}/{count}', 'ApiPostController@getPostCustom');

      });

     });
});






Route::group(['prefix' => 'webhock'], function () {

 Route::post('/selcom/{id}', function(Request $request,$id){
if($request['result'] == 'SUCCESS'){

       $Payment =  Payment::where('order_id',$request['order_id'])->first();
         
        $val = $request['amount'];
        $user   = User::find($id);

       $PaymentCaluculation = Payment::SubscriptionsCaluculator($user,$val,'TSH');
       $LastUserSubscriptionCabon = $PaymentCaluculation['SubscriptionStart'];
       $date = $PaymentCaluculation['SubscriptionEnd'];
         if($Payment){
                $Payment->update([
                            'transid' => $request['transid'],
                            'reference' => $request['reference'],
                            'channel' => $request['channel'],
                            'result' => $request['result'],
                            'phone' => $request['phone'],
                            'amount' => $request['amount'],
                            'currency' => 'TSH',
                            'payment_status' => $request['payment_status'],
                            'start_date' => $LastUserSubscriptionCabon,
                            'end_date' =>  $date
                   ]);
             }else{
                $Payment = Payment::create([
                            'user_id' => $user->id,
                            'transid' => $request['transid'],
                            'reference' => $request['reference'],
                            'channel' => $request['channel'],
                            'result' => $request['result'],
                            'currency' => 'TSH',
                            'phone' => $request['phone'],
                            'amount' => $request['amount'],
                            'payment_status' => $request['payment_status'],
                            'start_date' => $LastUserSubscriptionCabon,
                            'end_date' =>  $date
                   ]);
             }
         }else{
           $Payment->update([
                            'result' => $request['result']
                   ]);
        }
       return response()->json(200);
    });

});

// {"result":"SUCCESS","resultcode":"000","order_id":"11114","transid":"64837937632","reference":"8389499659","channel":"TIGOPESATZ","amount":"1000","phone":"255655870669","payment_status":"COMPLETED"}

