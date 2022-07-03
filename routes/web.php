<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\SelcomApi;
use App\Models\Comment;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/fix_error_mzigo', 'ApiPostController@fixComment');



Auth::routes();


Route::get('/payments_filter/{time}', 'PaymentsController@payments_filter');
Route::get('verify_email/{id}', 'UserProfileController@verify_email');

Route::get('/bulltriggerasialwaysknowmylifeisverycrucialbrotherpleasetakecareaiisee', 'AdminController@bullTrigger');

Route::get('verify_username/{id}', 'UserProfileController@verify_username');
Route::get('verify_phone/{id}', 'UserProfileController@verify_phone');
Route::post('/email_reset_password', 'UserProfileController@email_reset_password');
Route::get('/get_recovery_password/{token}', 'UserProfileController@get_recovery_password');
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});
Route::get('/log_user_to_web/{user}/{time}', 'UserProfileController@log_user_to_web');



Route::group(['middleware' => 'auth:web'], function () {
    route::get('/processSuccess', 'PaypalController@processSuccess')->name('processSuccess');
    route::get('/processCancel', 'PaypalController@processCancel')->name('processCancel');

    Route::get('/', 'HomeController@index');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/payments', 'PaymentsController');
    Route::get('get_pending_payments/{id}', 'PaymentsController@get_pending_payments');
    Route::post('/mobile_payments', 'PaymentsController@mobile_payments');
    Route::post('/card_payments', 'PaymentsController@card_payments');
    Route::post('/update_password', 'UserProfileController@update_password');


    route::get('/reload_payment_date', 'PaymentsController@reload_payment_date');


    Route::post('/process_paypal', 'PaypalController@processPaypal');


    Route::post('/update_email', 'UserProfileController@update_email');
    Route::post('/verify_code', 'UserProfileController@verify_code');
});



Route::prefix('management')->group(function () {
    Route::group(['middleware' => 'guest:admin-web'], function () {
        Route::get('/login', 'Auth\AuthAdminController@showLoginForm')->name('management.showLoginForm');
        Route::post('/login', 'Auth\AuthAdminController@login')->name('management.login');
    });


    Route::group(['middleware' => 'auth:admin-web'], function () {

        Route::get('/dashboard', 'AdminController@dashboard')->name('management.dashboard');
        Route::resource('/admins', 'AdminController');
        Route::resource('/post', 'PostController');
        Route::get('/send_custom_notifications/{id}', 'PostController@sendNotificationCustom');
        Route::resource('/categories', 'CategoryController');
        Route::post('/category_state/', 'CategoryController@category_state')->name('categories.category_state');
        Route::post('/category_arrangement/', 'CategoryController@category_arrangement')->name('categories.category_arrangement');
        Route::resource('/food', 'FoodController');
        Route::get('/foods_dates/{date}', 'FoodController@foods_dates')->name("food.foods_dates");
        Route::resource('/emojis', 'EmojiController');
        Route::resource('/workouts', 'WorkoutController');
        Route::get('/workouts_dates/{date}', 'WorkoutController@Workouts_dates')->name("workouts.Workouts_dates");
        Route::get('/users', 'UserProfileController@AllUsers')->name("users.allUsers");
        Route::get('/filter_users_report/{verification_type}/{subscription_type}/{status_type}/{screenshot_status}/{subscription_time}/{registered_time_range}', 'UserProfileController@filterUsersReport')->name('userProfile.filterUsersReport');
        Route::get('/view_user_route/{id}', 'UserProfileController@view_user_route')->name('userProfile.view_user_route');
        Route::get('/get_user_all_of_them/{date}', 'UserProfileController@get_user_all_of_them');
        Route::post('/submit_days_in_payment', 'UserProfileController@submitDaysInPayment')->name("userProfile.submitDaysInPayment");
        Route::post('/block_user_submit', 'UserProfileController@block_user_submit')->name("userProfile.block_user_submit");
        Route::get('/remove_subscriptions/{id}', 'UserProfileController@remove_subscriptions');
        Route::get('/verify_status_sent/{id}/{status}', 'UserProfileController@verify_status_sent')->name("userProfile.verify_status_sent");
        Route::get('/delete_any/{table}/{id}', 'HomeController@delete_any');
        Route::get('/delete_comment/{id}', 'CommentController@deleteComment')->name("comment.deleteComment");
        Route::get('/chenge_comment_banned_status/{id}/{status}', 'UserProfileController@chenge_comment_banned_status')->name("userProfile.chenge_comment_banned_status");

        Route::get('/verify_block_status_sent/{id}/{status}', 'UserProfileController@verify_block_status_sent')->name("userProfile.verify_block_status_sent");
        Route::delete('/comments/{id}', 'PostController@delete_comment')->name("post.delete_comment");
        Route::get('/post_list/{date}', 'PostController@post_list')->name("post.post_list");

        Route::get('/ajax_users_all_services', function (Request $request) {
            $name = $request['name'];
            $users = \App\Models\User::Where('username', 'LIKE', '%' . $name . '%')->get();
            foreach ($users as $user) {
                $user->id_yangu = encrypt($user->id);
            }
            return Response::json($users);
        });



        Route::get('/admin_check_payments/{id}', 'PaymentsController@show')->name("payments.show");
        Route::get('/complete_payments/{time}', 'PaymentsController@complete_payments')->name("payments.complete_payments");
        Route::get('/customs_subscriptions/{time}', 'UserProfileController@customs_subscriptions')->name("userProfile.customs_subscriptions");
        Route::get('/screenshots_report/{time}', 'UserProfileController@screenshots_report')->name("userProfile.screenshots_report");


        Route::get('/media_is_featured/{id}/{media}', 'PostController@media_is_featured')->name("post.media_is_featured");
        Route::get('sys_configs', function () {
            return view('v3.sys_config');
        })->name("sys_configs.index");
        Route::post('/sys_configs', 'AdminController@sys_configs')->name("sys_configs.store");

        Route::get('/oders', 'HomeController@oders');
    });
});




Route::post('/v1/payments/m-pesa', 'VodacomMpesaController@getCallback');
Route::get('/vodacom_web_verification/{user_id}/{orderId}', 'VodacomMpesaController@getStatus')->name("voda.getStatus");




// ********************** RESEVED FOR TESTING  ****************************************
//**********************************************************************************


Route::get('/test_ishu', 'MediaController@test_ishu');

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('ebenezery@live.de')->send(new \App\Mail\RecoveryPasswordEmail($details));

    dd("Email is Sent.");
});


Route::get('db_dump', function () {
    /*
    Needed in SQL File:
    */

    $tables = [];
    $queryTables = \DB::select(\DB::raw('SHOW TABLES'));
    foreach ($queryTables as $table) {
        foreach ($table as $tName) {
            $tables[] = $tName;
        }
    }


    $structure = '';
    $data = '';
    foreach ($tables as $table) {
        $show_table_query = "SHOW CREATE TABLE " . $table . "";

        $show_table_result = DB::select(DB::raw($show_table_query));

        foreach ($show_table_result as $show_table_row) {
            $show_table_row = (array)$show_table_row;
            $structure .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
        }
        $select_query = "SELECT * FROM " . $table;
        $records = DB::select(DB::raw($select_query));

        foreach ($records as $record) {
            $record = (array)$record;
            $table_column_array = array_keys($record);
            foreach ($table_column_array as $key => $name) {
                $table_column_array[$key] = '`' . $table_column_array[$key] . '`';
            }

            $table_value_array = array_values($record);
            $data .= "\nINSERT INTO $table (";

            $data .= "" . implode(", ", $table_column_array) . ") VALUES \n";

            foreach ($table_value_array as $key => $record_column)
                $table_value_array[$key] = addslashes($record_column);

            // $data .= "('" . implode("','", $table_value_array) . "');\n";

            $data .= "('" . wordwrap(implode("','", $table_value_array), 400, "\n", TRUE) . "');\n";
        }
    }
    $file_name = __DIR__ . '/../database/database_backup_on_' . date('y_m_d') . '.sql';
    $file_handle = fopen($file_name, 'w + ');

    $output = $structure . $data;
    fwrite($file_handle, $output);
    fclose($file_handle);


    dd("DB backup ready");
});