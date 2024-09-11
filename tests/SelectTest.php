<?php declare(strict_types=1);

namespace Roka\DML;

use PHPUnit\Framework\TestCase;

final class SelectTest extends TestCase
{
    public function testDefaults(): void
    {
        $select = new Select();
        $this->assertSame(['*'], $select->getFields());
        $this->assertSame([], $select->getJoins());
        $this->assertSame([], $select->getWhere());
        $this->assertSame(null, $select->getLimit());
        $this->assertSame(false, $select->hasLimit());
        $this->assertSame(1, $select->getPage());
        $this->assertSame(0, $select->getOffset());
    }

    public function testSetFields(): void
    {
        $select = new Select();
        $select->setFields('foo', 'bar');
        $this->assertSame(['foo', 'bar'], $select->getFields());
        $select->setFields('Alice', 'Bob');
        $this->assertSame(['Alice', 'Bob'], $select->getFields());
    }

    public function testSetFields_Exception_ZeroLengthField(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length field: "1"');

        $select = new Select();
        $select->setFields('foo', '');
    }

    public function testGetField(): void
    {
        $select = new Select();
        $select->setFields('foo', 'bar');
        $this->assertSame('foo', $select->getField(0));
        $this->assertSame('bar', $select->getField(1));
    }

    public function testGetField_Exception_FieldNotSet(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Field not set: "1"');

        $select = new Select();
        $select->setFields('foo');
        $select->getField(1);
    }

    public function testFrom(): void
    {
        $select = new Select();
        $select->from('foo');
        $this->assertSame('foo', $select->getFrom());
    }

    public function testFrom_Exception_ZeroLengthFrom(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length FROM');

        $select = new Select();
        $select->from('');
    }

    public function testJoin(): void
    {
        $select = new Select();
        $select->join('foo');
        $this->assertSame(['foo'], $select->getJoins());
        $select->join('bar');
        $this->assertSame(['foo', 'bar'], $select->getJoins());
    }

    public function testJoin_Exception_ZeroLengthJoin(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length JOIN');

        $select = new Select();
        $select->join('');
    }

    public function testLeftJoin(): void
    {
        $select = new Select();
        $select->leftJoin('foo');
        $this->assertSame(['foo'], $select->getJoins());
        $select->leftJoin('bar');
        $this->assertSame(['foo', 'bar'], $select->getJoins());
    }

    public function testLeftJoin_Exception_ZeroLengthJoin(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length LEFT JOIN');

        $select = new Select();
        $select->leftJoin('');
    }

    public function testRightJoin(): void
    {
        $select = new Select();
        $select->rightJoin('foo');
        $this->assertSame(['foo'], $select->getJoins());
        $select->rightJoin('bar');
        $this->assertSame(['foo', 'bar'], $select->getJoins());
    }

    public function testRightJoin_Exception_ZeroLengthJoin(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length RIGHT JOIN');

        $select = new Select();
        $select->rightJoin('');
    }

    public function testGetJoin(): void
    {
        $select = new Select();
        $select->join('foo');
        $this->assertSame('foo', $select->getJoin(0));
        $select->join('bar');
        $this->assertSame('bar', $select->getJoin(1));
    }

    public function testGetJoin_Exception_JoinNotSet(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Join not set: "1"');

        $select = new Select();
        $select->join('foo');
        $select->getJoin(1);
    }

    public function testWhere(): void
    {
        $select = new Select();
        $select->where('foo');
        $this->assertSame(['foo'], $select->getWhere());
        $select->where('bar');
        $this->assertSame(['foo', 'bar'], $select->getWhere());
    }

    public function testWhere_Exception_ZeroLengthWhere(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length WHERE');

        $select = new Select();
        $select->where('');
    }

    public function testGroupBy(): void
    {
        $select = new Select();
        $select->groupBy('foo');
        $this->assertSame('foo', $select->getGroupBy());
        $select->groupBy('bar');
        $this->assertSame('bar', $select->getGroupBy());
    }

    public function testGroupBy_Exception_ZeroLengthGroupBy(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length GROUP BY');

        $select = new Select();
        $select->groupBy('');
    }

    public function testHaving(): void
    {
        $select = new Select();
        $select->having('foo');
        $this->assertSame('foo', $select->getHaving());
        $select->having('bar');
        $this->assertSame('bar', $select->getHaving());
    }

    public function testHaving_Exception_ZeroLengthHaving(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length HAVING');

        $select = new Select();
        $select->having('');
    }

    public function testOrderBy(): void
    {
        $select = new Select();
        $select->orderBy('foo');
        $this->assertSame('foo', $select->getOrderBy());
        $select->orderBy('bar');
        $this->assertSame('bar', $select->getOrderBy());
    }

    public function testOrderBy_Exception_ZeroLengthOrderBy(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length ORDER BY');

        $select = new Select();
        $select->orderBy('');
    }

    public function testSetLimit(): void
    {
        $select = new Select();
        $select->setLimit(1);
        $this->assertSame(1, $select->getLimit());
        $this->assertSame(true, $select->hasLimit());
        $select->setLimit(2);
        $this->assertSame(2, $select->getLimit());
        $this->assertSame(true, $select->hasLimit());
        $select->setLimit(0);
        $this->assertSame(0, $select->getLimit());
        $this->assertSame(true, $select->hasLimit());
        $select->setLimit();
        $this->assertSame(null, $select->getLimit());
        $this->assertSame(false, $select->hasLimit());
    }

    public function testSetLimit_Exception_NegativeLimit(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Negative LIMIT');

        $select = new Select();
        $select->setLimit(-1);
    }

    public function testSetPage(): void
    {
        $select = new Select();
        $select->setPage(2);
        $this->assertSame(2, $select->getPage());
        $select->setPage(3);
        $this->assertSame(3, $select->getPage());

        $select = new Select();
        $select->setLimit(10);
        $select->setPage(3);
        $this->assertSame(20, $select->getOffset());
        $select->setPage(4);
        $this->assertSame(30, $select->getOffset());
    }

    public function testSetPage_Exception_ZeroPage(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero page');

        $select = new Select();
        $select->setPage(0);
    }
}
