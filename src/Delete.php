<?php

namespace Roka\DML;

final class Delete
{
    protected string $from;
    protected array $where = [];
    protected ?int $limit = null;

    public function from(string $from): self
    {
        if (strlen($from) === 0) {
            throw new DeleteException('Zero length FROM');
        }

        $this->from = $from;
        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function where(string $where): self
    {
        if (strlen($where) === 0) {
            throw new DeleteException('Zero length WHERE');
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
            throw new DeleteException('Negative LIMIT');
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
