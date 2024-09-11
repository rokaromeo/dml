<?php

namespace Roka\DML;

final class Insert
{
    protected string $table;
    protected array $fields = [];
    protected array $values = [];
    protected array $on_duplicate_key_update = [];

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

    public function getValues(int $row_index = null): array
    {
        if ($row_index === null) {
            return $this->values;
        }

        if (! array_key_exists($row_index, $this->values)) {
            throw new InsertException(sprintf('Row is not set: "%d"', $row_index));
        }

        return $this->values[$row_index];
    }

    public function getRowCount(): int
    {
        return count($this->values);
    }

    public function onDuplicateKeyUpdateFields(string ...$fields): self
    {
        $this->on_duplicate_key_update = [];

        foreach ($fields as $field) {
            if (! $this->hasField($field)) {
                throw new InsertException(sprintf('Field is not set: "%s"', $field));
            }

            $this->on_duplicate_key_update[$field] = null;
        }

        return $this;
    }

    public function onDuplicateKeyUpdateValues(array $fields_and_values): self
    {
        $this->on_duplicate_key_update = [];

        foreach ($fields_and_values as $field => $value) {
            if (! $this->hasField($field)) {
                throw new InsertException(sprintf('Field is not set: "%s"', $field));
            }

            $this->on_duplicate_key_update[$field] = $value;
        }

        return $this;
    }

    public function getOnDuplicateKeyUpdate(): array
    {
        return $this->on_duplicate_key_update;
    }
}
