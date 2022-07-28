<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationToListMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contributor, $manager, $link)
    {
        $this->contributor = $contributor;
        $this->manager = $manager;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Mr Vibbraneo Enterprise - Invitation to list')
            ->view('emails.invitation_to_list')
            ->with([
                'contributor' => $this->contributor,
                'manager' => $this->manager,
                'link' => $this->link,
            ]);
    }
}
