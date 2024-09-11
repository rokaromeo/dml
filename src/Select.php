<?php

namespace Roka\DML;

final class Select
{
    protected array $fields = ['*'];

    public function setFields(string ...$fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function GetFields(): array
    {
        return $this->fields;
    }
}
