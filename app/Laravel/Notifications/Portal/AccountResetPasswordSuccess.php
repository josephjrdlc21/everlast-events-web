<?php

namespace App\Laravel\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountResetPasswordSuccess extends Mailable
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
        $this->subject("Events Account Reset Password Success");
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('emails.portal.account-reset-password-success')
            ->with([
                'password' => $this->data['password'],
                'email' => $this->data['email'],
                'date_time' => $this->data['date_time'], 
                'setting' => $this->data['setting'],
            ]);
    }
}
