<?php

namespace Roka\DML;

final class Select
{
    protected array $fields = ['*'];
    protected string $from;
    protected array $joins = [];

    public function setFields(string ...$fields): self
    {
        foreach ($fields as $key => $field) {
            if (strlen($field) === 0) {
                throw new SelectException(sprintf('Zero length field: "%d"', $key));
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
            throw new SelectException(sprintf('Field not set: "%s"', $field_id));
        }

        return $this->getFields()[$field_id];
    }

    public function from(string $from): self
    {
        if (strlen($from) === 0) {
            throw new SelectException('Zero length FROM');
        }

        $this->from = $from;
        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function join(string $join): self
    {
        if (strlen($join) === 0) {
            throw new SelectException('Zero length JOIN');
        }

        $this->joins[] = $join;
        return $this;
    }

    public function leftJoin(string $join): self
    {
        if (strlen($join) === 0) {
            throw new SelectException('Zero length LEFT JOIN');
        }

        $this->joins[] = $join;
        return $this;
    }

    public function rightJoin(string $join): self
    {
        if (strlen($join) === 0) {
            throw new SelectException('Zero length RIGHT JOIN');
        }

        $this->joins[] = $join;
        return $this;
    }

    public function getJoins(): array
    {
        return $this->joins;
    }

    public function getJoin(int|string $join_id): string
    {
        if (! array_key_exists($join_id, $this->getJoins())) {
            throw new SelectException(sprintf('Join not set: "%s"', $join_id));
        }

        return $this->getJoins()[$join_id];
    }
}
