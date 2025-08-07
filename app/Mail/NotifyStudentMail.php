<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyStudentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $startDate;
    public $endDate;

    public function __construct($subjectText, $startDate, $endDate)
    {
        $this->subjectText = $subjectText;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this
            ->subject($this->subjectText)
            ->view('emails.notify-student')
            ->with([
                'subjectText' => $this->subjectText,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ]);
    }
}
