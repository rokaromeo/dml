<?php declare(strict_types=1);

namespace Roka\DML;

use PHPUnit\Framework\TestCase;

final class DeleteTest extends TestCase
{
    public function testDefaults(): void
    {
        $delete = new Delete();
        $this->assertSame([], $delete->getWhere());
        $this->assertSame(null, $delete->getLimit());
    }

    public function testFrom(): void
    {
        $delete = new Delete();
        $delete->from('foo');
        $this->assertSame('foo', $delete->getFrom());
    }

    public function testFrom_Exception_ZeroLengthFrom(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length FROM');

        $delete = new Delete();
        $delete->from('');
    }

    public function testWhere(): void
    {
        $delete = new Delete();
        $delete->where('foo');
        $this->assertSame(['foo'], $delete->getWhere());
        $delete->where('bar');
        $this->assertSame(['foo', 'bar'], $delete->getWhere());
    }

    public function testWhere_Exception_ZeroLengthWhere(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Zero length WHERE');

        $delete = new Delete();
        $delete->where('');
    }

    public function testSetLimit(): void
    {
        $delete = new Delete();
        $delete->setLimit(1);
        $this->assertSame(1, $delete->getLimit());
        $this->assertSame(true, $delete->hasLimit());
        $delete->setLimit(2);
        $this->assertSame(2, $delete->getLimit());
        $this->assertSame(true, $delete->hasLimit());
        $delete->setLimit(0);
        $this->assertSame(0, $delete->getLimit());
        $this->assertSame(true, $delete->hasLimit());
        $delete->setLimit();
        $this->assertSame(null, $delete->getLimit());
        $this->assertSame(false, $delete->hasLimit());
    }

    public function testSetLimit_Exception_NegativeLimit(): void
    {
        $this->expectException(SelectException::class);
        $this->expectExceptionMessage('Negative LIMIT');

        $delete = new Delete();
        $delete->setLimit(-1);
    }
}
