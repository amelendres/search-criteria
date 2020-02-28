<?php

namespace Appto\Booking\Application\Request\Definition;

use OpenApi\Annotations as OA;

/**
 * @author  Alfredo Melendres <alfredo.melendres@gmail.com>
 *
 * @OA\Schema(
 *     description="Request requester",
 *     title="Request requester",
 *     required={"name", "email", "phoneNumber"},
 *     @OA\Xml(
 *         name="requester"
 *     )
 * )
 **/
class RequesterDefinition
{
    /**
     * @OA\Property()
     * @var string
     */
    public $name;

    /**
     * @OA\Property()
     * @var string
     */
    public $email;

    /**
     * @OA\Property()
     * @var string
     */
    public $phoneNumber;

    public function __construct(string $name, string $email, string $phoneNumber)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }
}
