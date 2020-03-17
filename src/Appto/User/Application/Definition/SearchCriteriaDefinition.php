<?php

namespace Appto\User\Application\Definition;

class SearchCriteriaDefinition
{
    public $filters;
    public $order;

    /**
     * @param FilterDefinition[] $filters
     * @param string[] $order
     */
    public function __construct(
        array $filters,
        array $order
    ) {
        $this->order = $order;
        array_map(
            function (FilterDefinition $filter) {
                $this->add($filter);
            },
            $filters
        );
    }

    private function add(FilterDefinition $filter) : void
    {
        $this->filters[$filter->name] = $filter;
    }

    public function filter(string $key) : ?FilterDefinition
    {
        //WIP isset validator
        return $this->has($key) ?  $this->filters[$key] : null;
    }

    public function has(string $key) : bool
    {
        return isset($this->filters[$key]);
    }
}
