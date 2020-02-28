<?php

namespace Appto\Booking\Domain\Request;


class Requester
{
    private $name;
    private $email;
    private $phoneNumber;

    public function __construct(string $name, string $email, string $phoneNumber)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function phoneNumber() : string
    {
        return $this->phoneNumber;
    }
}
