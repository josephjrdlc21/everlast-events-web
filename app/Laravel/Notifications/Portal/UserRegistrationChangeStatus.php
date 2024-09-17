<?php

namespace App\Laravel\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationChangeStatus extends Mailable
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
        $this->subject("Events User Registration Status");
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('emails.portal.user-registration-change-status')
            ->with([
                'status' => $this->data['status'],
                'email' => $this->data['email'],
                'date_time' => $this->data['date_time'], 
                'setting' => $this->data['setting'],
            ]);
    }
}
