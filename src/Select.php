<?php

namespace Roka\DML;

final class Select
{
    protected array $fields = ['*'];

    public function setFields(string ...$fields): self
    {
        foreach ($fields as $field) {
            if (strlen($field) === 0) {
                throw new SelectException('Zero length field in Select statement');
            }
        }

        $this->fields = $fields;
        return $this;
    }

    public function GetFields(): array
    {
        return $this->fields;
    }
}
