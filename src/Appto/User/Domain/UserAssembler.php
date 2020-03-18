<?php

namespace Appto\User\Domain;

interface UserAssembler
{
    public function assemble(array $data): User;
}
