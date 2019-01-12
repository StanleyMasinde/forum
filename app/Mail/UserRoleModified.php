<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRoleModified extends Mailable
{
    use Queueable, SerializesModels;

    public $old_role;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($old_role, $user)
    {
        $this->old_role = $old_role;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.UserRoleModified');
    }
}
