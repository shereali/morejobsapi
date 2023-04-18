<?php

namespace App\Events;

class AuthEvent extends Event
{
    public $data;
    public $acctAutoVerified;

    public function __construct(array $data, $acctAutoVerified = false)
    {
        $this->data = $data;
        $this->acctAutoVerified = $acctAutoVerified;
    }
}
