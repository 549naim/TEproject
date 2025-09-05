<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyTeacherMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
 

    public function __construct($subjectText)
    {
        $this->subjectText = $subjectText;
       
    }

    public function build()
    {
        return $this
            ->subject($this->subjectText)
            ->view('emails.notify-teacher')
            ->with([
                'subjectText' => $this->subjectText,
            ]);
    }
}
