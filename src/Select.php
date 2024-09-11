<?php

namespace Roka\DML;

final class Select
{
    protected array $fields = ['*'];

    public function GetFields()
    {
        return $this->fields;
    }
}
