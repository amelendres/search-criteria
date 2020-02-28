<?php

namespace Appto\Booking\Application\Request\Definition;

use OpenApi\Annotations as OA;

/**
 * @author  Alfredo Melendres <alfredo.melendres@gmail.com>
 *
 * @OA\Schema(
 *     title="Request view model",
 *     description="Request view model",
 *     @OA\Xml(
 *         name="request view"
 *     )
 * )
 **/
class RequestViewDefinition extends RequestDefinition
{

    /**
     * @OA\Property()
     * @var Boolean
     */
    public $isAvailable;


    /**
     * @OA\Property()
     * @var null|PriceDefinition
     */
    public $price;

    public function __construct(
        string $id,
        string $boatId,
        string $portId,
        int $numberOfPassengers,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        RequesterDefinition $requester,
        ?string $comment,
        bool $isAvailable,
        ?PriceDefinition $price
    ) {
        parent::__construct(
            $id,
        $boatId,
        $portId,
        $numberOfPassengers,
        $startDate,
        $endDate,
        $requester,
        $comment
        );

        $this->isAvailable = $isAvailable;
        $this->price = $price;

    }


}
