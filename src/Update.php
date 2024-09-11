<?php

namespace Roka\DML;

final class Update
{
    protected string $table;
    protected array $where = [];
    protected ?int $limit = null;

    public function table(string $table): self
    {
        if (strlen($table) === 0) {
            throw new SelectException('Zero length table name');
        }

        $this->table = $table;
        return $this;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function where(string $where): self
    {
        if (strlen($where) === 0) {
            throw new SelectException('Zero length WHERE');
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
            throw new SelectException('Negative LIMIT');
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
