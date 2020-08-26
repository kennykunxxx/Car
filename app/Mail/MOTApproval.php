<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class MOTApproval extends Mailable
{
    use Queueable, SerializesModels;
    protected $approval;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval)
    {
        $this->approval = $approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.template')->with('approval', $this->approval);

    }
}
