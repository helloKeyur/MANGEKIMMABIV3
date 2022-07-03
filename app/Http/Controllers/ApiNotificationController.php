<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;


class ApiNotificationController extends Controller
{

	   //profile_page redirect to profiel  
	   //passenger_riding type passanger riding redirect;

		public static function sendNotifications($header, $message, $post_id, $delay = null, $url = "null" ) {

				    $content      = array(
				        "en" => $header
				    );

					$subtitle = array(
				     	"en" => $message
					);

				    $hashes_array = array();

				    array_push($hashes_array, array(
				        "id" => "like-button",
				        "text" => "Like",
				        "icon" => url('/logo.png'),
				        "url" => $url
				    ));

				    $fields = array(
				        'app_id' => "ae75022a-8ef9-40b5-9271-a8c51f82a5fb",
				        'included_segments' => array(
				            'All'
				        ),
				        'data' => array(
				            "post_id" => $post_id
				        ),
				        'headings' => $subtitle,
				        'contents' => $content,
				        'small_icon' => url('/logo.png'),
				        'large_icon' => url('/logo.png'),
				        'web_buttons' => $hashes_array
				    );

				if($delay != null){
				$fields['send_after'] = Carbon::parse($delay)->format('Y-m-d H:i:s TO');
				}
				    
				    $fields = json_encode($fields);

				    
				    $ch = curl_init();
				    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
				    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				        'Content-Type: application/json; charset=utf-8',
				        'Authorization: Basic ZTY3YzMwNjgtYWFmNi00ZTQxLTgxYTItNWYwOGI0NmJjM2E5'
				    ));
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				    curl_setopt($ch, CURLOPT_HEADER, FALSE);
				    curl_setopt($ch, CURLOPT_POST, TRUE);
				    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				    
				    $response = curl_exec($ch);
				    curl_close($ch);
				    
				    return $response;
				}

				public static function cancel_nofitication($notification_id)
				{       
					    $url = "https://onesignal.com/api/v1/notifications/".$notification_id."?app_id=ae75022a-8ef9-40b5-9271-a8c51f82a5fb";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				        'Content-Type: application/json; charset=utf-8',
				        'Authorization: Basic ZTY3YzMwNjgtYWFmNi00ZTQxLTgxYTItNWYwOGI0NmJjM2E5'
				        ));
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
						$result = curl_exec($ch);
						$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						curl_close($ch);
						return $result;
				}
                


      // if you pass the time please pass datetime

public static   function sendNotificationsUserSpecified($header , $message , $ids , $post_id = "null" ,$delay = null){

        $content = array(
            "en" => $message
            );
         $subtitle = array(
            "en" => $header 
            );

                    $hashes_array = array();

				    array_push($hashes_array, array(
				        "id" => "like-button",
				        "text" => "Like",
				        "icon" => url('/logo.png'),
				        "url" => ""
				    ));

        
        $fields = array(
            'app_id' => "ae75022a-8ef9-40b5-9271-a8c51f82a5fb",
            'include_player_ids' => $ids,  //array must be
            'data' => array( "post_id" => $post_id),
            'headings' => $subtitle,
            'contents' => $content,
            'small_icon' => url('/logo.png'),
		    'large_icon' => url('/logo.png'),
            'web_buttons' => $hashes_array
        );

        if($delay != null){
        	$fields['send_after'] = Carbon::parse($delay)->format('Y-m-d H:i:s TO');
        }
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic ZTY3YzMwNjgtYWFmNi00ZTQxLTgxYTItNWYwOGI0NmJjM2E5'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }



}


