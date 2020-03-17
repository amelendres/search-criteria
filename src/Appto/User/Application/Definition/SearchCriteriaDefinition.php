<?php

namespace Appto\User\Application\Definition;

class SearchCriteriaDefinition
{
    public $activationLength;
    public $country;
    public $order;

    /**
     * @param string[] $country
     * @param string[] $order
     */
    public function __construct(
        int $activationLength,
        array $country,
        array $order
    ) {
        $this->activationLength = $activationLength;
        $this->country = $country;
        $this->order = $order;
    }
}
