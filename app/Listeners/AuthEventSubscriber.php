<?php

namespace App\Listeners;

use App\Events\AuthEvent;
use App\Models\User;
use App\Services\AccountService;
use App\Services\StaticValueService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthEventSubscriber
{
    public function handleUserCreate(AuthEvent $event)
    {
        $event->data['password'] = Hash::make($event->data['password']);

        $user = User::create($event->data + [
                'account_verification_token' => AccountService::generateVerificationToken()
            ]);
\Log::info('Auth event subscriber');
\Log::info($event->data['reg_medium']);
        $user->contacts()->create([
            'title' => $event->data['username'],
            'type' => $event->data['reg_medium'] == StaticValueService::regMediumId('email') ? 1 : 2,
            'is_default' => 1
        ]);

        if ($event->acctAutoVerified) {
            $user->account_verification_token = null;
            $user->account_verified_at = Carbon::now()->toDateTimeString();
            $user->save();

        } else {
            AccountService::sendVerificationCode($user);
        }


        AccountService::sendWelcomeMessage($user);

        return $user;
    }

    public function subscribe($events)
    {
        $events->listen(
            AuthEvent::class,
            'App\Listeners\AuthEventSubscriber@handleUserCreate'
        );
    }
}
