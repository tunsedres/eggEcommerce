<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisteredSubscriber implements EventSubscriberInterface
{
    public function onUserRegistered($event)
    {
        dd($event);
    }

    public static function getSubscribedEvents()
    {
        return [
           'user.registered' => 'onUserRegistered',
        ];
    }
}
