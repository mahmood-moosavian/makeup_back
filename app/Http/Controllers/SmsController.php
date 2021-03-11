<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kavenegar\KavenegarApi;

class SmsController extends Controller
{
    private $api_key;
    private $sender;

    public function __construct()
    {
        $this->api_key = config('sms.api_key');
        $this->sender = config('sms.sender');
    }

    public function send($receptor, $message, $token, $template){
        try {
            $sms = new KavenegarApi($this->api_key);
            return $sms->send($this->sender, $receptor, $message);

            // return $sms->VerifyLookup($receptor, $token, null, null, $template, null);


        } catch (\Throwable $th) {
            report($th);
        }
        
    }
}
