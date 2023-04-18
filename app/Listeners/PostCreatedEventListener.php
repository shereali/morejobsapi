<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use App\Services\AuthService;

class PostCreatedEventListener
{

    public function handle(PostCreatedEvent $event)
    {
        if ($event->request->input('mode') == 'edit'){
            return  $this->update($event->request->all());
        }

        return $this->store($event->request->all());
    }

    private function store($data)
    {
        $a =  AuthService::getCompany();

        dd($a);
    }

    private function update($data)
    {

    }
}
