<?php

namespace Roka\DML;

final class Replace
{
    protected string $table;
    protected array $data = [];

    public function table(string $table): self
    {
        if (strlen($table) === 0) {
            throw new ReplaceException('Zero length table name');
        }

        $this->table = $table;
        return $this;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function setValue(string $field, $value = null): self
    {
        if (strlen($field) === 0) {
            throw new ReplaceException('Zero length field name');
        }

        $this->data[$field] = $value;
        return $this;
    }

    public function setValues(array $fields_and_values): self
    {
        foreach ($fields_and_values as $field => $value) {
            $this->setValue($field, $value);
        }

        return $this;
    }

    public function getValue(string $field)
    {
        if (! array_key_exists($field, $this->data)) {
            throw new ReplaceException(sprintf('Field not set: "%s"', $field));
        }

        return $this->data[$field];
    }

    public function getValues(): array
    {
        return $this->data;
    }
}
