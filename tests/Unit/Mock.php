<?php

namespace Test\Unit;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;

abstract class Mock
{
    private $resource;

    public function __construct(MockBuilder $mockBuilder)
    {
        $this->resource = $mockBuilder->getMock();
    }

    public function mock() : MockObject
    {
        return $this->resource;
    }
}
