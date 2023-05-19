<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function sendMail()
    {
        $to = 'burian@cinovahora.cz';
        $mailData = [
            'title' => 'Demo Email',
            'link' => 'https://www.icewarp.com',
            'from' => 'ivomir@seznam.cz',
            'to' => 'ivomir@seznam.cz',
            'subject' => 'Test',  
            'idoforder' => '5654',  
            'bcc' => 'ivomir@seznam.cz'
        ];
        Mail::to($to)->send(new SignUp($mailData));
        return response()->json(['message' => 'Email has been sent.', 'status' => '200'], 
                                 Response::HTTP_OK);
    }
}
