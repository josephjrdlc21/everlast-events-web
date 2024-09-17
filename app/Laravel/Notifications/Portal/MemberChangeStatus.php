<?php

namespace App\Laravel\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberChangeStatus extends Mailable
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
        $this->subject("Events Member Change Status");
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->view('emails.portal.member-change-status')
            ->with([
                'email' => $this->data['email'],
                'status' => $this->data['status'],
                'date_time' => $this->data['date_time'], 
                'setting' => $this->data['setting'],
            ]);
    }
}
