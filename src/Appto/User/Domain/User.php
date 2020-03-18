<?php

namespace Appto\User\Domain;


class User
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $country;
    public $createdAt;
    public $activatedAt;
    public $chargeId;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
        string $country,
        string $createdAt,
        string $activatedAt,
        int $chargeId
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->country = $country;
        $this->createdAt = $createdAt;
        $this->activatedAt = $activatedAt;
        $this->chargeId = $chargeId;
    }
}
