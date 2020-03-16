<?php

namespace Appto\User\Infrastructure\Api\Presenter;

use Appto\Common\Application\ListPresenter;

class FindAllUserPresenter implements ListPresenter
{
    public $data;

    public function write($objects) : void
    {
        $this->data = !empty($objects) ? ['items' => $objects] : [];
    }

    public function read() : array
    {
        return $this->data;
    }

}
