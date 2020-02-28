<?php

namespace Appto\Booking\Application\Request\Definition;

use OpenApi\Annotations as OA;

/**
 * @author  Alfredo Melendres <alfredo.melendres@gmail.com>
 *
 * @OA\Schema(
 *     description="Booking request price ",
 *     title="Price",
 *     @OA\Xml(
 *         name="price"
 *     )
 * )
 **/
class PriceDefinition
{
    /**
     * @OA\Property()
     * @var float
     */
    public $amount;

    /**
     * @OA\Property()
     * @var string
     */
    public $currency;

    public function __construct(float $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }
}
