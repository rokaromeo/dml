<?php

namespace Roka\DML;

final class Update
{
    protected string $table;
    protected array $data = [];
    protected array $where = [];
    protected ?int $limit = null;

    public function table(string $table): self
    {
        if (strlen($table) === 0) {
            throw new UpdateException('Zero length table name');
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
            throw new UpdateException('Zero length field name');
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
            throw new UpdateException(sprintf('Field not set: "%s"', $field));
        }

        return $this->data[$field];
    }

    public function getValues(): array
    {
        return $this->data;
    }

    public function where(string $where): self
    {
        if (strlen($where) === 0) {
            throw new UpdateException('Zero length WHERE');
        }

        $this->where[] = $where;
        return $this;
    }

    public function getWhere(): array
    {
        return $this->where;
    }

    public function setLimit(?int $limit = null): self
    {
        if ($limit < 0) {
            throw new UpdateException('Negative LIMIT');
        }

        $this->limit = $limit;
        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function hasLimit(): bool
    {
        return $this->getLimit() !== null;
    }
}
