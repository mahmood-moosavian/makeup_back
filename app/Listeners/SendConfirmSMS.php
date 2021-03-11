<?php

namespace App\Listeners;

use App\Events\AttempLogin;
use App\Http\Controllers\SmsController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendConfirmSMS
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AttempLogin $event)
    {
        //Send SMS code confirm
        $user = $event->get_user();
        $token = rand(1234,9876);
        $user->active_code = $token;
        $user->save();
        $message = "کد ورود: \n {$token}";
        $template = "Login";
        $sms = new SmsController();
        return $sms->send($user->mobile, $message, $token, $template);
        
    }
}
