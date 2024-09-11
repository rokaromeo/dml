<?php

namespace Roka\DML;

final class Insert
{
    protected bool $ignore = false;
    protected string $table;
    protected array $fields = [];
    protected array $values = [];
    protected array $on_duplicate_key_update = [];

    public function ignore(): self
    {
        $this->ignore = true;
        return $this;
    }

    public function doNotIgnore(): self
    {
        $this->ignore = false;
        return $this;
    }

    public function isIgnored(): bool
    {
        return $this->ignore;
    }

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

    public function onDuplicateKeyUpdate(string|array $field, string ...$fields): self
    {
        $this->on_duplicate_key_update = [];

        if (is_string($field)) {
            $fields = [$field, ...$fields];
            $fields_and_values = [];
            foreach ($fields as $field) {
                $fields_and_values[$field] = sprintf('values(`%s`)', $field);
            }
        }

        if (is_array($field)) {
            $fields_and_values = $field;
        }

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

    public function getSQL(): string
    {
        $SQL = [];

        if ($this->isIgnored()) {
            $SQL[] = sprintf('INSERT IGNORE INTO `%s` ', $this->getTable());
        } else {
            $SQL[] = sprintf('INSERT INTO `%s` ', $this->getTable());
        }

        $SQL[] = sprintf('(`%s`) ', implode('`, `', $this->getFields()));
        $SQL[] = 'VALUES ';

        $rows = [sprintf('(:%s)', implode(', :', $this->getFields()))];
        for ($i = 1; $i < $this->getRowCount(); $i++) {
            $rows[$i] = sprintf('(:%s%d)', implode(sprintf('%d, :', $i), $this->getFields()), $i);
        }

        $SQL[] = implode(', ', $rows);

        return implode('', $SQL);
    }
}
