<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; 
use App\Models\User;

class ApiHelper
{
    public static function setJosnData($value)
    {
        array_walk_recursive($value, function (&$item, $key) {
            $item = null === $item ? '' : strval($item);
        });
        return $value;
    }

    public static function sendNotification($user_id=false,$title=false,$message=false)
    { 
        $GetUserDetail = User::where('id', @$user_id)->first(['device_token']); 
        $device_token = @$GetUserDetail->device_token;
        
        try 
        {
            if(!empty($device_token)){

                $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
                $token = @$device_token;   
                $title = @$title;   
                $message = strip_tags(@$message);   
 
                $notification = array('title' =>$title , 'text' => $message);
 
                $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $notification, 'priority'=>'high');
 
                $json = json_encode($arrayToSend); 
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization:key=AAAAUC5u4jY:APA91bH_AmOfYuqUBLK5jNOwlBBslZe1r8Q0d8RS5FIx-B6-kGQU9v6y_jp7oegmSEk-xxRjiSBAbJnKAhVPTpQ9ZHTw8hB2sJZQEQgYcfC9K9tA2MgfTG6SatmRpRH9Hg9Vey4rCEJ5'; // API key here
         
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $resp = curl_exec($ch); 

                if(!curl_errno($ch)){
                    $info = curl_getinfo($ch);  
                } 
                curl_close($ch);
                return response()->json(['status' => true, 'msg' => 'Notification sent successfully.', 'data' => $resp]); 
            }else{ 
                return response()->json(['status' => false, 'error' => 'token not found']);
            }   
         }catch (\Exception $e) { 
             return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }  
    }

    public static function sendSMS($messageid, $variables_values, $numbers)
    {
        try {
            $data = [
                'authorization' => env('SMS_API_KEY'),
                'sender_id' => env('SMS_SENDER_ID'),
                'message' => $messageid,
                'variables_values' => $variables_values,
                'route' => 'dlt',
                'numbers' => $numbers
            ];
            $response = Http::get('https://www.fast2sms.com/dev/bulkV2', $data);
            return response()->json(['status' => true, 'msg' => 'SMS sent successfully.', 'data' => $response]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
 
}
