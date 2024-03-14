<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function basic_email()
    {
        $data = array('name' => "John Doe");
        Mail::mailer('smtp')->send(['text' => 'mail'], $data, function ($message) {
            $message->to('denurbanow@gmail.com', 'Johnny Metal')->subject('Laravel Basic Testing Mail');
            $message->from('john.doe@example.org', 'John Doe');
        });
        echo 'Check your Inbox';
    }
}
