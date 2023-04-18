<?php

namespace App\Events;

use App\Http\Requests\PostRequest;

class PostCreatedEvent extends Event
{
    public $request;

    public function __construct(PostRequest $request)
    {
        $this->request = $request;
    }
}
