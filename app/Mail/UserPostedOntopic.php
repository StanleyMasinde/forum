<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPostedOntopic extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;
    public $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($topic, $post)
    {
        $this->post = $post;
        $this->topic = $topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.UserPostedOnTopic');
    }
}
