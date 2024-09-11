<?php

namespace Roka\DML;

final class Select
{
    protected array $fields = ['*'];
    protected string $from;
    protected array $joins = [];
    protected array $where = [];
    protected string $group_by;
    protected string $having;
    protected string $order_by;
    protected ?int $limit = null;
    protected int $offset = 0;
    protected int $page = 1;

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

    public function groupBy(string $group_by): self
    {
        if (strlen($group_by) === 0) {
            throw new SelectException('Zero length GROUP BY');
        }

        $this->group_by = $group_by;
        return $this;
    }

    public function getGroupBy(): string
    {
        return $this->group_by;
    }

    public function having(string $having): self
    {
        if (strlen($having) === 0) {
            throw new SelectException('Zero length HAVING');
        }

        $this->having = $having;
        return $this;
    }

    public function getHaving(): string
    {
        return $this->having;
    }

    public function orderBy(string $order_by): self
    {
        if (strlen($order_by) === 0) {
            throw new SelectException('Zero length ORDER BY');
        }

        $this->order_by = $order_by;
        return $this;
    }

    public function getOrderBy(): string
    {
        return $this->order_by;
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

    public function setOffset(int $offset = 0): self
    {
        if ($offset < 0) {
            throw new SelectException('Negative OFFSEt');
        }

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setPage(int $page = 1): self
    {
        if ($page < 1) {
            throw new SelectException('Zero page');
        }

        $this->page = $page;
        if ($this->hasLimit()) {
            $this->offset = (int) $this->getLimit() * ($this->getPage() - 1);
        }

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
