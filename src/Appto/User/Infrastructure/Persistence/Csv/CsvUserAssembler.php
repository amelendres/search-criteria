<?php

namespace Appto\User\Infrastructure\Persistence\Csv;

use Appto\User\Domain\User;
use Appto\User\Domain\UserAssembler;

class CsvUserAssembler implements UserAssembler
{

    public function assemble(array $data) : User
    {
        return new User(
            $data[0],
            $data[1],
            $data[2],
            $data[3],
            $data[4],
            $data[5],
            $data[6],
            $data[7]
        );
    }
}
