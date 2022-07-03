<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


     public function user(){
        return $this->belongsTo("App\Models\User","user_id");
     }





     public static function SubscriptionsCaluculator($user,$amount,$currency){

      if(isset($user->end_of_subscription_date)){
         if(\Carbon\Carbon::parse($user->end_of_subscription_date) < \Carbon\Carbon::now()){
            $LastUserSubscriptionCabon =  \Carbon\Carbon::now();
            $SubscriptionStart = \Carbon\Carbon::now();
          }else{
            $LastUserSubscriptionCabon = \Carbon\Carbon::parse($user->end_of_subscription_date); 
            $SubscriptionStart = \Carbon\Carbon::parse($user->end_of_subscription_date); 
          }
        }else{
           $LastUserSubscriptionCabon =  \Carbon\Carbon::now();
           $SubscriptionStart = \Carbon\Carbon::now();
        }
       
        


      if($currency == "TSH"){
            if($amount == 1000){
               $date = $LastUserSubscriptionCabon->addMonth();
           }else if($amount == 3000){
                $date = $LastUserSubscriptionCabon->addMonths(3);
           }else if($amount == 5000){
                $date = $LastUserSubscriptionCabon->addMonths(6);
           }else if($amount == 10000){
               $date = $LastUserSubscriptionCabon->addMonths(12);
           }else{
               $date = $LastUserSubscriptionCabon->addMonth();  
           }

      }else{
          if($amount == '2.00'){
            $date = $LastUserSubscriptionCabon->addMonth();
           }else if($amount == '3.00'){
            $date = $LastUserSubscriptionCabon->addMonths(3);
           }else if($amount == '5.00'){
             $date = $LastUserSubscriptionCabon->addMonths(6);
           }else if($amount == '10.00'){
               $date = $LastUserSubscriptionCabon->addMonths(12);
           }else{
            $date = $LastUserSubscriptionCabon->addMonth();  
          }
      }


      $user->update([ 'end_of_subscription_date' => $date,
                        'is_subscribed' => true
                        ]);


      return [
               'SubscriptionStart' => $SubscriptionStart,
               'SubscriptionEnd' => $date,
                  ];

        
    }
}
