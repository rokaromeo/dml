<?php declare(strict_types=1);

namespace Roka\DML;

use PHPUnit\Framework\TestCase;

final class UpdateTest extends TestCase
{
    public function testDefaults(): void
    {
        $update = new Update();
        $this->assertSame([], $update->getValues());
        $this->assertSame([], $update->getWhere());
        $this->assertSame(null, $update->getLimit());
    }

    public function testTable(): void
    {
        $update = new Update();
        $update->table('foo');
        $this->assertSame('foo', $update->getTable());
    }

    public function testTable_Exception_ZeroLengthTable(): void
    {
        $this->expectException(UpdateException::class);
        $this->expectExceptionMessage('Zero length table name');

        $update = new Update();
        $update->table('');
    }

    public function testSetValue(): void
    {
        $replace = new Replace();
        $replace->setValue('foo', 'bar');
        $this->assertSame(['foo' => 'bar'], $replace->getValues());
        $replace->setValue('foo2', 'bar2');
        $this->assertSame(['foo' => 'bar', 'foo2' => 'bar2'], $replace->getValues());
    }

    public function testSetValue_Exception_ZeroLengthFieldName(): void
    {
        $this->expectException(ReplaceException::class);
        $this->expectExceptionMessage('Zero length field name');

        $replace = new Replace();
        $replace->setValue('', 'bar');
    }

    public function testSetValues(): void
    {
        $replace = new Replace();
        $replace->setValues(['foo' => 'bar', 'foo2' => 'bar2']);
        $this->assertSame(['foo' => 'bar', 'foo2' => 'bar2'], $replace->getValues());
    }

    public function testSetValues_Exception_ZeroLengthFieldName(): void
    {
        $this->expectException(ReplaceException::class);
        $this->expectExceptionMessage('Zero length field name');

        $replace = new Replace();
        $replace->setValues(['' => 'bar']);
    }

    public function testWhere(): void
    {
        $update = new Update();
        $update->where('foo');
        $this->assertSame(['foo'], $update->getWhere());
        $update->where('bar');
        $this->assertSame(['foo', 'bar'], $update->getWhere());
    }

    public function testWhere_Exception_ZeroLengthWhere(): void
    {
        $this->expectException(UpdateException::class);
        $this->expectExceptionMessage('Zero length WHERE');

        $update = new Update();
        $update->where('');
    }

    public function testSetLimit(): void
    {
        $update = new Update();
        $update->setLimit(1);
        $this->assertSame(1, $update->getLimit());
        $this->assertSame(true, $update->hasLimit());
        $update->setLimit(2);
        $this->assertSame(2, $update->getLimit());
        $this->assertSame(true, $update->hasLimit());
        $update->setLimit(0);
        $this->assertSame(0, $update->getLimit());
        $this->assertSame(true, $update->hasLimit());
        $update->setLimit();
        $this->assertSame(null, $update->getLimit());
        $this->assertSame(false, $update->hasLimit());
    }

    public function testSetLimit_Exception_NegativeLimit(): void
    {
        $this->expectException(UpdateException::class);
        $this->expectExceptionMessage('Negative LIMIT');

        $update = new Update();
        $update->setLimit(-1);
    }
}
