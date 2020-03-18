<?php

namespace Appto\Common\Application;

Interface ListPresenter
{
    public function write($objects) : void;

    public function read() : array;
}
