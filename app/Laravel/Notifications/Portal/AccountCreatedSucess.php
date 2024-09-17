<?php

namespace App\Laravel\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreatedSucess extends Mailable
{
    use Queueable;
    use SerializesModels;
    
    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($data)
    {
        $this->data = $data;
        $this->subject("Events Account Created Success");
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('emails.portal.account-created-success')
            ->with([
                'email' => $this->data['email'],
                'password' => $this->data['password'],
                'date_time' => $this->data['date_time'], 
                'setting' => $this->data['setting'],
            ]);
    }
}
