<?php

namespace App\Listeners;

use App\Mail\UserRegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisterEmailListner
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
    public function handle( $event)
    {
        //
     
        $email = $event->user['email']; //get user email.
        Mail::to($email)->send(new UserRegisterMail($event->user));


    }
}
