<?php

namespace App\Event;

class UserRegistered
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}