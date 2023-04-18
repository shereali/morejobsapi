<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailResumeSent extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $attachment;

    public function __construct($data, $attachment)
    {
        $this->data = $data;
        $this->attachment = $attachment;
    }


    public function build()
    {
        if ($this->attachment) {
            return $this->text($this->data->body)
                ->replyTo($this->data->email)
                ->subject($this->data->subject)
                ->attach($this->attachment);
        }

        return $this->text($this->data->body)
            ->replyTo($this->data->email)
            ->subject($this->data->subject);
    }
}
