<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUp extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailData; // email v array

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }


    public function build()
    {
        return $this->from(config('mail.sender'))
                ->bcc($this->mailData['bcc'])
                ->subject($this->mailData['id'])
                ->markdown('emailtemplates.'.$this->mailData['key']) // měním templaty
                ->with('mailData', $this->mailData);
    }
}
