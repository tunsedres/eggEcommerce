<?php


namespace App\Events;


use App\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcher;

class UserRegistered extends EventDispatcher
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}