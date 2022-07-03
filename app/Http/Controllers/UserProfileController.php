<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
use App\Models\Payment;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Models\CustomSubscription;
use App\Models\Screenshot;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function testMzigo(){
    //        $vars['user'] = app('firebase.firestore')->database()->collection("users")->where("username","=","mamadoreen")->documents();
    //        foreach($vars["user"] as $user){
    //          dd($user->data()["email"]);
    //        }
    // }



    public function email_reset_password(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        if ($user) {
            $time = Carbon::now();

            $user->update(['email_verified_at' => $time]);
            $details = [
                'title' => 'Mange kimambi App password recovery',
                'body' => 'Habari ' . $user->username . ' Tumekutumia Link ya kubadili password yako. Email hii itakupa Access ya kuingia kwenye akaunti yako maramoja tu hivyo ukiingia badili password yako.',
                'url' => url('/') . '/get_recovery_password/' . encrypt($time)
            ];
            \Mail::to($user->email)->send(new \App\Mail\RecoveryPasswordEmail($details));

            return response()->json(['done' => 'Tumekutumia Barua pepe (Email) fungua email yako ili urejeshe password yako ']);
        } else {
            return response()->json(['error' => 'Hatuna Email hii Kwenye record zetu']);
        }
    }


    public function get_recovery_password($token)
    {
        $user = User::where('email_verified_at', decrypt($token))->first();
        if ($user) {
            $user->update(['email_verified_at' => null]);
            \Auth::loginUsingId($user->id);
            return redirect('/home')->withMessage('Tafazali Badili password yako sasa')->with('flash_type', 'info')->with('flash_icon', 'fa-check-square-o');
        } else {
            return redirect('/login')->withMessage('Tokeni yako imekwisha muda wake')->with('flash_type', 'info')->with('flash_icon', 'fa-check-square-o');
        }
    }


    public function log_user_to_web($user, $time_token)
    {
        // dd([decrypt($user),$time_token]);
        $user = User::find(decrypt($user));
        if ($user) {
            if (md5($user->web_log_time) == $time_token) {
                $user->update(['web_log_time' => null]);
                \Auth::loginUsingId($user->id);
                return redirect('/home');
            } else {
                return redirect('/')->withMessage('Tokeni yako imekwisha muda wake')->with('flash_type', 'info')->with('flash_icon', 'fa-check-square-o');
            }
        } else {
            return redirect('/')->withMessage('User huyu hayupo kwenye mfumo wetu')->with('flash_type', 'info')->with('flash_icon', 'fa-check-square-o');
        }
    }


    public function update_password(Request $request)
    {
        $request['user_id'] =  \Auth::user()->id;

        if (!isset($request['user_id']) || $request['user_id'] == null) {
            \Session::flash('flash_message_error', 'User Not found. Select User First');

            return redirect()->back();
        }

        if ($request['passwordIsNew'] !== $request['passwordIs_confirmation']) {
            //   \Session::flash('flash_message_error','Account Passwords must match');
            // return redirect()->back();

            return response()->json(['error' => 'Password lazima zifanane ya kwanza na ya pili']);
        } else {
            $password = Hash::make($request['passwordIs_confirmation']);
            $user = User::find($request['user_id']);
            $user->password = $password;
            $user->save();
            // \Session::flash('flash_message',$user->name.' Password updated successful');
            // return redirect()->back();

            return response()->json(['done' => 'Password yako imabadilishwa ']);
        }
    }

    public function update_email(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['id']);
        $users = User::where('email', $input['email'])->where("id", "!=", Auth::user()->id)->exists();
        if (!$user) {
            return redirect()->back()->withMessage('User Not Found')->with('flash_type', 'danger')->with('flash_icon', 'fa-check-square-o');
        }
        if ($users) {
            return redirect()->back()->withMessage('Barua pepe inatumika na mtu mwingine tafadhali badilisha')->with('flash_type', 'danger')->with('flash_icon', 'fa-check-square-o');
        }

        $input['verify_code'] = mt_rand(1000, 9999);

        // TODO:: send this code to this email = $input['email']


        $user->update(["email" => $input['email'], "verify_code" => $input['verify_code']]);

        return redirect()->back()->withMessage('Tumetuma Namba ya uthibitisho/verification code kwenye Barua pepe/email yako ambayo utatumia kuthibitisha ya kwamba hii Barua pepe/Email ni yako')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');
    }

    public function verify_code(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['id']);
        if (!$user) {
            return redirect()->back()->withMessage('User Not Found')->with('flash_type', 'danger')->with('flash_icon', 'fa-check-square-o');
        }
        if ($user->verify_code != $input['verification']) {
            return redirect()->back()->withMessage('Namba ya uthibitisho/Verification code uliyoingiza sio sahihi tafadhari rudia tena')->with('flash_type', 'danger')->with('flash_icon', 'fa-check-square-o');
        }

        $user->update(["email_verified_at" => Carbon::now()]);

        return redirect()->back()->withMessage('Umefaulu kuthibisha email/Barua pepe yako hongera endelea kuenjoy mangekimambi app news ')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');
    }

    // public function allUsersController(){
    //     $vars['title'] = "All Users";
    //     $vars['sub_title'] = "Users List";

    //     $user = User::first();
    //     if($user){
    //         $start = $user->created_at;
    //     }else{
    //        $start    = Carbon::now(); // Today date 
    //     }


    //     $end    = Carbon::now();// Today date
    //     $interval = DateInterval::createFromDateString('1 month'); // 1 month interval
    //     $period   = new DatePeriod($start, $interval, $end); // Get a set of date beetween the 2 period

    //     $count = $end->diffInMonths($start);

    //     return view("backend.users.index_firebase",compact('vars','period','count'));
    // }

    public function filterUsersReport($verification_type, $subscription_type, $status_type, $screenshot_status, $subscription_time, $registered_time_range)
    {

        $query = User::whereNotNull("id");
        if ($status_type != "all") {
            $query = $query->where("status", $status_type);
        }

        if ($verification_type != "all") {
            $query = $query->where("is_verified", $verification_type);
        }
        if ($subscription_type != "all") {
            $query = $query->where("is_subscribed", $subscription_type);
        }
        if ($screenshot_status != "all") {
            if ($screenshot_status == "has") {
                $query = $query->has("screenshots");
            } else {
                $query = $query->doesntHave("screenshots");
            }
        }
        if ($subscription_time != "all") {
            $date = explode("~", $subscription_time);
            $from = Carbon::parse($date[0])->startOfDay();
            $end = Carbon::parse($date[1])->endOfDay();
            $query = $query->whereBetween("end_of_subscription_date", [$from, $end]);
        }

        if ($registered_time_range != "all") {
            $date = explode("~", $registered_time_range);
            $from = Carbon::parse($date[0])->startOfDay();
            $end = Carbon::parse($date[1])->endOfDay();
            $query = $query->whereBetween("created_at", [$from, $end]);
        }

        $vars['users'] = $query->get();

        $view =  view("v3.backend.users._tr", compact('vars'))->render();
        return response()->json($view);
    }

    public function AllUsers()
    {
        $vars['title'] = "All Users";
        $vars['sub_title'] = "Users List";



        $user = User::first();
        if ($user) {
            $start = $user->created_at;
        } else {
            $start    = Carbon::now(); // Today date 
        }

        $vars['users'] = User::paginate(3000);
        // dd($vars['users']);
        $end    = Carbon::now(); // Today date
        $interval = DateInterval::createFromDateString('1 month'); // 1 month interval
        $period   = new DatePeriod($start, $interval, $end); // Get a set of date beetween the 2 period

        $count = $end->diffInMonths($start);

        return view("v3.backend.users.index_firebase", compact('vars', 'period', 'count'));
    }

    public function get_user_all_of_them($date)
    {

        $vars['users'] = User::whereMonth('created_at', Carbon::parse($date))->get();
        // dd($vars['users']);
        $view =  view("backend.users._tr", compact('vars'))->render();
        return response()->json($view);
    }

    public function view_user_route($id)
    {
        $id = decrypt($id);
        $vars['title'] = "View User Details";
        $vars['sub_title'] = "User List";
        $vars['user'] = User::find($id);

        $vars["payments"] = Payment::where("user_id", $id)->get();
        $vars["subscriptions"] = CustomSubscription::where("user_id", $id)->get();
        $vars["screenshots"] = Screenshot::where("user_id", $id)->get();
        $vars["comments"] = Comment::where("user_id", $id)->get();
        // return view("backend.users._view_firebase", compact('vars'));
        return view("v3.backend.users._view_firebase", compact('vars'));
    }

    public function customs_subscriptions($time)
    {
        $custom_data = explode('~', $time);
        $vars['from_date'] =  $custom_data[0];
        $vars['to_date'] =  $custom_data[1];
        $vars['time'] =  $time;

        $vars['subscriptions'] = CustomSubscription::whereBetween("created_at", [Carbon::parse($vars['from_date'])->startOfDay(),  Carbon::parse($vars['to_date'])->endOfDay()])->get();

        return view('v3.backend.users.customs_subscriptions', compact('vars'));
    }


    public function screenshots_report($time)
    {

        $custom_data = explode('~', $time);
        $vars['from_date'] =  $custom_data[0];
        $vars['to_date'] =  $custom_data[1];
        $vars['time'] =  $time;

        $vars['screenshots'] = Screenshot::whereBetween("created_at", [Carbon::parse($vars['from_date'])->startOfDay(),  Carbon::parse($vars['to_date'])->endOfDay()])->get();

        return view('v3.backend.users.screenshots_report', compact('vars'));
    }






    public function block_user_submit(Request $request)
    {
        $user   = User::find($request->id);
        $input = $request->all();
        $user->update($input);
        return redirect()->back();
    }

    public function submitDaysInPayment(Request $request)
    {
        // 007cIoSI4YN5ksoJZlQn8ZrzvNv2
        $user   = User::find($request->id);

        if ($user->subscriptionDate) {
            $userSubscriptionTimestamp = $user->subscriptionDate;
        } else {
            $userSubscriptionTimestamp =  Carbon::now();
        }

        if (Carbon::now() > $userSubscriptionTimestamp) {
            $LastUserSubscriptionCabon = Carbon::now();
        } else {
            $LastUserSubscriptionCabon = $userSubscriptionTimestamp;
        }

        $date = $LastUserSubscriptionCabon->addDays($request->days);

        $user->update([
            'end_of_subscription_date' => $date,
            'is_subscribed' => 'true',
        ]);

        CustomSubscription::create([
            "amount_days" => $request->days,
            "user_id" => $request->id,
            "admin_id" => Auth::user()->id,
            "start_date" => $LastUserSubscriptionCabon,
            "end_date" => $date,
            "status" => "Added"
        ]);

        return redirect()->back();
    }

    public function remove_subscriptions($id)
    {
        $user   = User::find($id);

        CustomSubscription::create([
            "user_id" => $id,
            "admin_id" => Auth::user()->id,
            "end_date" => $user->end_of_subscription_date,
            "status" => "Removed"
        ]);
        $user->update([
            'end_of_subscription_date' => null,
            'is_subscribed' => 'false',
        ]);
        return response()->json();
    }

    public function verify_status_sent($id, $status)
    {
        $user   = User::find($id);
        $user->update(['is_verified' => $status,]);
        return response()->json();
    }
    public function chenge_comment_banned_status($id, $status)
    {
        $user   = User::find($id);
        $user->update(['comment_status' => $status, 'comment_banned_by_id' => Auth::user()->id]);
        return response()->json();
    }

    public function verify_block_status_sent($id, $status)
    {
        $user   = User::find($id);
        $user->update(['status' => $status,]);
        return response()->json();
    }






    public function verify_email($name)
    {

        $users = User::where('email', $name)->exists();
        return response()->json($users);
    }

    public function getUserName($name)
    {
    }

    public function verifyUsername($name)
    {
        $users = User::where('username', $name)->exists();
        return response()->json($users);
    }


    public function verify_phone($name)
    {
        $users = User::where('phone', $name)->exists();
        return response()->json($users);
    }

    public function index()
    {

        $uid = Session::get('uid');
        // dd(\Carbon\Carbon::now()->addDays(30)->timestamp*1000); 
        $vars['title'] = "User Profile";
        $vars['users'] = app('firebase.firestore')->database()->collection("users")->document($uid);
        $vars['user'] = app('firebase.firestore')->database()->collection("users")->document($uid)->snapshot();
        $vars['user'] = (object)($vars['user']->data());

        if (isset($vars['user']->subscriptionDate) && $vars['user']->subscriptionDate != "" && $vars['user']->subscriptionDate) {
        } else {

            if (isset($vars['user']->websubscriptionDate) && $vars['user']->websubscriptionDate != "" && $vars['user']->websubscriptionDate) {

                $date = date("Y-m-d", $vars['user']->websubscriptionDate / 1000);
                $reliable = Carbon::parse($date)->endOfDay();
                if (Carbon::now() < $reliable) {
                    $verify = true;
                } else {
                    $verify = false;
                }

                $vars['users']->set([
                    'subscriptionDate' => $vars['user']->websubscriptionDate,
                    'isSubscribed' => $verify,
                    'webisSubscribed' => $verify
                ], ['merge' => true]);
            }
        }

        $vars['user'] = app('firebase.firestore')->database()->collection("users")->document($uid)->snapshot();
        $vars['user'] = (object)($vars['user']->data());





        if (isset($vars['user']->image) && $vars['user']->image) {
            $expiresAt = new \DateTime('tomorrow');
            $imageReference = app('firebase.storage')->getBucket()->object($vars['user']->image);

            if ($imageReference->exists()) {
                $vars['user']->profile = $imageReference->signedUrl($expiresAt);
            } else {
                $vars['user']->profile = "";
            }
        } else {
            $vars['user']->profile = "";
        }

        return view('frontend.profile', compact('vars'));
    }

    public function verifyUser($phone, $uid)
    {
        $user = app('firebase.firestore')->database()->collection("users")->document($uid)->snapshot();
        if (!$user->data()) {
            $posts = app('firebase.firestore')->database()->collection('users')->document($uid);
            $posts->set([
                'userId' => $uid,
                'password' => "",
                'cpassword' => "",
                'phone' => $phone,
                'email' => "",
                'name' => "",
                'image' => "",
                'status' => 'online',
            ], ['merge' => true]);
        }
        Session::put('uid', $uid);
        $user = ["localId" => $uid, "email" => $phone, "name" => "",];
        $user = new User($user);
        $result = Auth::login($user);
        return redirect('/');
    }


    public function verifyOtp(Request $request)
    {
        $object = $request->object;
        $phone = $request->phone;
        return view("auth.verify_otp", compact("object", "phone"));
    }


    public function contact_us_form(Request $request)
    {
        dd($request->all());
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->back();
        }
        $vars['title'] = "My Profile";
        $vars['user'] = User::find($id);
        $vars['devices'] = \DB::table('sessions')
            ->where('user_id', \Auth::user()->id)
            ->get()->reverse();
        $vars['position'] = "Staff";
        return view('profile._view', compact('vars'))->with('current_session_id', \Session::getId());
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
        if ($request->profile_image) {
            $imageDeleted = app('firebase.storage')->getBucket()->object($request->profile_image)->delete();
        }

        $image = $request->file('profile_picture'); //image file from frontend
        $user   = app('firebase.firestore')->database()->collection('users')->document($id);
        $firebase_storage_path = 'image/profilePics/';
        $name     = $id;
        $localfolder = public_path('firebase-temp-uploads') . '/';
        $extension = $image->getClientOriginalExtension();
        $file      = $name . '.' . $extension;
        if ($image->move($localfolder, $file)) {
            $uploadedfile = fopen($localfolder . $file, 'r');
            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $name]);
            //will remove from local laravel folder
            unlink($localfolder . $file);

            $user->set([
                'image' => $firebase_storage_path . $name,
            ], ['merge' => true]);
        } else {
        }

        return redirect('/');
    }


    public function UserInfoupdate(Request $request)
    {

        $user   = app('firebase.firestore')->database()->collection('users')->document($request['id']);
        $user->set([
            'name' => $request['name'],
            'phone' => $request['phone']
        ], ['merge' => true]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    public function test()
    {

        $uid = Session::get('uid');
        // dd(\Carbon\Carbon::now()->timestamp*1000); 
        $vars['title'] = "User Profile";
        $vars['user'] = app('firebase.firestore')->database()->collection("users")->document($uid)->snapshot();
        // dd($vars['user']->exists());
        // if(!$vars['user']->exists()){
        //      Session::flush();
        //      return redirect('/');
        // }
        $vars['user'] = (object)($vars['user']->data());



        if (isset($vars['user']->image) && $vars['user']->image) {
            $expiresAt = new \DateTime('tomorrow');
            $imageReference = app('firebase.storage')->getBucket()->object($vars['user']->image);

            if ($imageReference->exists()) {
                $vars['user']->profile = $imageReference->signedUrl($expiresAt);
            } else {
                $vars['user']->profile = "";
            }
        } else {
            $vars['user']->profile = "";
        }

        return view('frontend.test', compact('vars'));
    }
}