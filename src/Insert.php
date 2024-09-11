<?php

namespace Roka\DML;

final class Insert
{
    protected string $table;
    protected array $fields = [];
    protected array $values = [];

    public function table(string $table): self
    {
        if (strlen($table) === 0) {
            throw new InsertException('Zero length table name');
        }

        $this->table = $table;
        return $this;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getFields(): array
    {
        return array_keys($this->fields);
    }

    public function hasField(string $field = null): bool
    {
        if ($field === null) {
            return $this->fields !== [];
        }

        return array_key_exists($field, $this->fields);
    }

    public function setValue(string $field, $value = null, int $row_index = 0): self
    {
        if (strlen($field) === 0) {
            throw new InsertException('Zero length field name');
        }

        $this->fields[$field] = count($this->fields);
        $this->values[$row_index][$field] = $value;
        return $this;
    }

    public function setValues(array $fields_and_values, int $row_index = 0): self
    {
        $rows = [$fields_and_values];
        if (is_array($fields_and_values) && is_array(reset($fields_and_values))) {
            $rows = reset($rows);
        }

        foreach ($rows as $row_index => $row) {
            foreach ($row as $field => $value) {
                $this->setValue($field, $value, $row_index);
            }
        }

        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getRowCount(): int
    {
        return count($this->values);
    }
}