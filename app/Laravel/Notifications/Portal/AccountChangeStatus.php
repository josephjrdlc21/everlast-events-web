<?php

namespace App\Laravel\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountChangeStatus extends Mailable
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
        $this->subject("Events Account Change Status");
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('emails.portal.account-change-status')
            ->with([
                'email' => $this->data['email'],
                'status' => $this->data['status'],
                'date_time' => $this->data['date_time'], 
                'setting' => $this->data['setting'],
            ]);
    }
}
