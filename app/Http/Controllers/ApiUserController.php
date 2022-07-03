<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\OauthClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Screenshot;
use App\Models\Feedback;
use App\Models\SysConfig;
use Image;



class ApiUserController extends Controller
{
    // Api authenitaction

    public function getData()
    {
        if(Carbon::parse(Auth::user()->end_of_subscription_date) < Carbon::now()){
           Auth::user()->update(["is_subscribed" => "false"]);
        }
        return response()->json([
                'success' => true,
                'user' => User::encrypter(Auth::user()),
            ]);
    }

    public function refreshLastPayment(){
        $user_id = Auth::user()->id;
    }

    public function addEmailForUser(Request $request){

        $input = $request->all();
        $user = User::find(Auth::user()->id);
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
            ], 401);
        }
        $users = User::where('email',$input['email'])->where("id","!=",Auth::user()->id)->exists();
         return response()->json([
                'success' => false,
                'message' => 'Barua pepe inatumika na mtu mwingine tafadhali badilisha',
            ], 401);

          $input['verify_code'] = mt_rand(1000, 9999);

       // TODO:: send this code to this email = $input['email']

        $user->update(["email" => $input['email'] , "verify_code" => $input['verify_code']]);
        return response()->json([
                'success' => true,
                'message' => 'Tumetuma Namba ya uthibitisho/verification code kwenye Barua pepe/email yako ambayo utatumia kuthibitisha ya kwamba hii Barua pepe/Email ni yako',
            ], 200);
    }


     public function verifyUsername($name){
         $key = \Request::header('key');
         $exists = OauthClient::where("secret",$key)->exists();

        if(!$exists){
           return response()->json([
                'success' => false,
                'message' => 'Client Not Found',
            ], 401);
        }
         $users = User::where('username',$name)->exists();
         return response()->json($users);

    }

    public function addVerificationForUser(Request $request){
         $input = $request->all();
         $user = User::find(Auth::user()->id);
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
            ], 401);
        }
        if($user->verify_code != User::decrypter($input['verification'])){
            return response()->json([
                'success' => false,
                'message' => 'Namba ya uthibitisho/Verification code uliyoingiza sio sahihi tafadhari rudia tena',
            ], 401);
        }

        $user->update(["email_verified_at" => Carbon::now()]);

        return response()->json([
                'success' => true,
                'message' => 'Umefaulu kuthibisha email/Barua pepe yako hongera endelea kuenjoy mangekimambi app news',
            ], 200);
    }


    public function getwebUrl(){

         $user = Auth::user();
         $time = Carbon::now();
         $user->update(['web_log_time' => $time]);
         $url = url('/').'/log_user_to_web/'. encrypt(Auth::user()->id).'/'.md5($time);
        return response()->json([
                'success' => true,
                'url' => User::encrypter($url),
            ]);
    }

    public function get_user_data($id){

        $user = User::find($id);

        if($user){
          return response()->json([
                'success' => true,
                'user' => User::encrypter($user),
            ]);  
      }else{
         return response()->json([
                'success' => false,
                'message' => 'User Not Found',
            ], 401);
       }
        
    }


     public function get_web_profile_redirection($id){

        $user = User::find($id);

        if($user){
          $time = Carbon::now();
         $user->update(['web_log_time' => $time]);
         $url = url('/').'/log_user_to_web/'. encrypt($id).'/'.md5($time);

             return response()->json([
                'success' => true,
                'url' => User::encrypter($url),
            ]);
        }else{
             return response()->json([
                    'success' => false,
                    'message' => 'User Not Found',
                ], 401);
           }
        
    }

    public function getAppInfo(){
        $info = SysConfig::select("app_version","app_status")->first();
        return response()->json([
                'success' => true,
                'info' => User::encrypter($info),
            ]);
    }

    public function submitNotificationToken(Request $request){
        $user = User::find(Auth::user()->id);
        $user->update(["login" => "Restrict"]);
        $user->update(["notification_token" => User::decrypter($request->token) ]);
         return response()->json([
                'success' => true,
                'message' => "Saved Successfully",
            ]);
    }

    public function submitUserScreenshots(){
        $input["user_id"] = Auth::user()->id;
        $input["date"] = date("Y-m-d");
        Screenshot::create($input);
         return response()->json([
                'success' => true,
                'message' => "Saved Successfully",
            ]);

    }

    public function login(Request $request)
    {
        

          if(filter_var(request('email'),FILTER_VALIDATE_EMAIL)){
            if (Auth::attempt(['email' => User::decrypter(request('email')), 'password' => User::decrypter(request('password'))])) {
                $user = Auth::user();
            }
            $type = "Email";
          }else{
            if (Auth::attempt(['username' => User::decrypter(request('email')), 'password' => User::decrypter(request('password'))])) {
                $user = Auth::user();
             }
              $type = "Username";
          }


        if (isset($user) && $user) {

            $user->update(["login" => "Restrict"]);
            
            foreach($user->accessTokens as $toke){
                   $toke->update([
                        'revoked' => true
                       ]);
            }

           $success['token'] = $user->createToken('appToken')->accessToken;      
            return response()->json([
                'success' => true,
                'token' => User::encrypter($success),
                'user' => User::encrypter($user),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => User::encrypter('Invalid '.$type.' or Password'),
            ], 401);
        }
    }

    public function deleteUser(){

         $user = Auth::user();
         $user->screenshots()->delete();
         $user->comments()->delete();
         $user->accessTokens()->delete();
         $user->delete();
         return response()->json([
                'success' => true,
                'message' => "User Deleted Successfully",
            ]);

    }


    public function RegisterTwo(Request $request)
    {
        

         $users = User::where('username',User::decrypter($request->username))->exists();

         if($users){
              return response()->json([
                'success' => false,
                'message' => User::encrypter("Username ".User::decrypter($request->username)." taken please change"),
            ], 401);
         }
        

        $validator = Validator::make($request->all(), [
            // 'name' => 'nullable|max:255',
            'username' => 'required|string',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => User::encrypter(implode('\n',  $validator->errors()->all())),
            ], 401);
        }

        $input = $request->all();

        $input['username'] = User::decrypter($input['username']);
        $input['password'] = User::decrypter($input['password']);
        $input['gender'] = User::decrypter($input['gender']);
        $input['name'] = User::decrypter($input['username']);

       
        $input['platform'] = "App"; 
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('appToken')->accessToken;
        $user = User::find($user->id);

        return response()->json([
            'success' => true,
            'token' => User::encrypter($success),
            'user' => User::encrypter($user)
        ]);
    }


    public function userSupport(Request $request){
        $support = Feedback::create([
           "name" => User::decrypter($request->name),
           "description" => User::decrypter($request->description),
           "entered_by_id" => Auth::user()->id,
        ]);
          if($file = $request->file('media')){
            foreach ($file as $key => $doc) {
                $name = time().$doc->getClientOriginalName();
                $doc->move('images/media', $name);
                $path= '/images/media/'.$name;
                $support->media()->create(['file_path'=>$path,
                        'type'=>'Image',
                        'belong_type'=>'App\Models\Feedback',
                        'belong_id'=>$support->id,
                        'entered_by_id'=>Auth::user()->id,
                       ]);
              }
        }
         return response()->json([
                'success' => true,
                'message' => "Saved Successfully",
            ]);
    }

    public function updateUser(Request $request)
    {

        $user = User::find(Auth::user()->id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => User::encrypter('User Not Found'),
            ], 401);
        }
        
        if (isset($request->img_url)) {

                    $file = User::decrypter($request->img_url);
                    $file = str_replace('data:image/png;base64,', '', $file);
                    if ($user->img_url) {
                    if (file_exists(public_path() . "\\" . $user->img_url)) {
                    unlink(public_path() . "\\" . $user->img_url);
                    }
                    $img_file = public_path().'/images/profile/'.$user->username.'_'.$user->id.'_'.time().'.png';
                    $path = '/images/profile/'.$user->username.'_'.$user->id.'_'.time().'.png';
                    $base64 = base64_decode($file);
                     \File::put($img_file, $base64);
                    $user->update(['img_url' => $path]);

            } else {

                    $img_file = public_path().'/images/profile/'.$user->username.'_'.$user->id.'_'.time().'.png';
                    $path = '/images/profile/'.$user->username.'_'.$user->id.'_'.time().'.png';
                    $base64 = base64_decode($file);
                    \File::put($img_file, $base64);
                    $user->update(['img_url' => $path]);

            }
        }

        $input = $request->all();
        unset($input['img_url']);

        if(isset($request->email) && $request->email){
                if (!filter_var(User::decrypter($request->email), FILTER_VALIDATE_EMAIL)) {
                   if($check){
                    return response()->json([
                        'success' => false,
                        'message' => User::encrypter('Invalid Email'),
                    ], 401); 
                    }
                }
             $check = User::where("email",User::decrypter($input["email"]))->where("id","!=",Auth::user()->id)->exists();
                if($check){
                    return response()->json([
                        'success' => false,
                        'message' => User::encrypter('Barua Pepe inatumika / Email exists Please change'),
                    ], 401); 
                }
            }else{
              // $input["email"] =   $user->email;
            }

        $user->update([
           "name" => User::decrypter($input["name"]), 
           "address" => User::decrypter($input["address"]), 
           "gender" => isset($input["gender"]) ? User::decrypter($input["gender"]) : $user->gender ,
           "email" => isset($input["email"]) ? User::decrypter($input["email"]) : $user->email ,
           "description" => User::decrypter($input["description"]), 
        ]);

     
        return response()->json([
            'success' => true,
            'user' => User::encrypter($user)
        ]);

    }

    public function renewUserCode(Request $request)
    {
        $user = User::find($request['id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => User::encrypter('User Not Found'),
            ], 401);
        }
        $check = User::where('phone',$request['phone'])->where('id','!=',$user->id)->exists();
         if ($check) {
            return response()->json([
                'success' => false,
                'message' => User::encrypter('The phone number '.$request['phone'].' is being used by another user'),
            ], 401);
        }
        $random_verify = mt_rand(1000, 9999);
        Sms::sendText(["255".$request['phone']],'Please verify your phone number by enter this Ushare code : '.$random_verify);
          Sms::create(['phone' => $request['phone'],
                'body' => 'Please verify your phone number by enter this Ushare code : '.$random_verify,
                 'status' => 'out',
                'state' => 'draft']);
        $user->update(['random_verify' => $random_verify, 'phone' => $request['phone']]);
        return response()->json([
            'success' => true,
            'message' => User::encrypter('New Phone successfully registered'),
        ]);
    }

    public function verifyUserCode(Request $request)
    {

        $user = User::find($request['user_id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
            ], 401);
        }

        $number  = $request['number1'].$request['number2'].$request['number3'].$request['number4'];

        if($user->random_verify != (int)$number){
            return response()->json([
                'success' => false,
                'message' => 'Incorrect code entered',
            ]);
        }

        $user->update(['phone_verify' => 'Yes']);
        
        return response()->json([
            'success' => true,
            'message' => 'Phone Number Verified Successfully',
            'user' => $user
        ]);
    }

public function password_recovery(Request $request)
    {
        

        $user = User::where('email',User::decrypter($request['email']))->first();
         if($user){
           $time = Carbon::now();

           $user->update(['email_verified_at' => $time]);
             $details = [
                'title' => 'Mange kimambi App password recovery',
                'body' => 'Habari '.$user->username.' Tumekutumia Link ya kubadili password yako. Email hii itakupa Access ya kuingia kwenye akaunti yako maramoja tu hivyo ukiingia badili password yako.',
                'url' => url('/').'/get_recovery_password/'. encrypt($time)
            ];
          \Mail::to($user->email)->send(new \App\Mail\RecoveryPasswordEmail($details));

           return response()->json([
            'success' => true,
            'message' => User::encrypter('Tumekutumia Barua pepe (Email) fungua email yako ili urejeshe password yako '),
        ]);
            
        }else{
             return response()->json([
                'success' => false,
                'message' => User::encrypter('User with this Email Not Found'),
            ], 401);
            
        }





        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => User::encrypter('User Not Found'),
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'message' => User::encrypter('Password recovery Sent to the Email  Successfully'),
        ]);
    }


   public function change_password(Request $request){
               $user = User::find(User::decrypter($request['user_id']));
               if(!$user){
                 return response()->json([
                        'success' => false,
                        'message' => User::encrypter('User not found')
                    ]);
               }

            if (!Hash::check(User::decrypter($request['old_password']), $user->password)){
                return response()->json([
                'success' => false,
                'message' => User::encrypter('Old password is wrong')
            ]);
            }  

            $password = bcrypt(User::decrypter($request['password']));

            $user->password =  $password;
            $user->save();

           return response()->json([
                'success' => true,
                'message' => User::encrypter('Password updated successfully')
            ]);

}

    public function updateMyEmail(Request $request){

        $check = User::where("email",User::decrypter($request->email))->exists();
        if($check){
            return response()->json([
                'success' => false,
                'message' => User::encrypter('Barua Pepe inatumika / Email exists Please change'),
            ], 401); 
        }
         Auth::user()->update(["email",User::decrypter($request->email)]);
         return response()->json([
                'success' => true,
                'message' => User::encrypter('Email updated successfully')
            ]);
    }


    public function logout(Request $res)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $user->update(["login" => "Allow"]);
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
                'success' => true,
                'message' => User::encrypter('Logout successfully')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => User::encrypter('Unable to Logout')
            ]);
        }
    }
}
