<?php

namespace Roka\DML;

final class Select
{
    protected array $fields = ['*'];

    public function setFields(string ...$fields): self
    {
        foreach ($fields as $field) {
            if (strlen($field) === 0) {
                throw new SelectException('Zero length field');
            }
        }

        $this->fields = $fields;
        return $this;
    }

    public function GetFields(): array
    {
        return $this->fields;
    }

    public function getField(int|string $field_id): string
    {
        if (! array_key_exists($field_id, $this->getFields())) {
            throw new SelectException(sprintf('Field id is not set: "%s"', $field_id));
        }

        return $this->getFields()[$field_id];
    }
}
