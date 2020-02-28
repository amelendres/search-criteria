<?php

namespace Appto\Booking\Application\Request\Definition;

use OpenApi\Annotations as OA;

/**
 * @author  Alfredo Melendres <alfredo.melendres@gmail.com>
 *
 * @OA\Schema(
 *     title="Request model",
 *     description="Request model",
 *     required={"id", "title", "content", "authorId", "publisherId"},
 *     @OA\Xml(
 *         name="request"
 *     )
 * )
 **/
class RequestDefinition
{
    /**
     * @OA\Property(format="uuid")
     * @var string
     */
    public $id;

    /**
     * @OA\Property(format="uuid")
     * @var string
     */
    public $boatId;

    /**
     * @OA\Property(format="uuid")
     * @var string
     */
    public $portId;

    /**
     * @OA\Property()
     * @var integer
     */
    public $numberOfPassengers;

    /**
     * @OA\Property()
     * @var \DateTimeInterface
     */
    public $startDate;

    /**
     * @OA\Property()
     * @var \DateTimeInterface
     */
    public $endDate;

    /**
     * @OA\Property()
     * @var RequesterDefinition
     */
    public $requester;

    /**
     * @OA\Property()
     * @var null|string
     */
    public $comment;

    public function __construct(
        string $id,
        string $boatId,
        string $portId,
        int $numberOfPassengers,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        RequesterDefinition $requester,
        ?string $comment
    ) {
        $this->id = $id;
        $this->boatId = $boatId;
        $this->portId = $portId;
        $this->numberOfPassengers = $numberOfPassengers;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->requester = $requester;
        $this->comment = $comment;
    }


}
