<?php

namespace Appto\User\Application\Definition;

class SearchCriteriaDefinition
{
    public $filters;
    public $order;

    /**
     * @param string[] $filters
     * @param string[] $order
     */
    public function __construct(
        array $filters,
        array $order
    ) {
        $this->filters = $filters;
        $this->order = $order;
    }
}
