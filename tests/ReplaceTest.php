<?php declare(strict_types=1);

namespace Roka\DML;

use PHPUnit\Framework\TestCase;

final class ReplaceTest extends TestCase
{
    public function testDefaults(): void
    {
        $replace = new Replace();
        $this->assertSame([], $replace->getValues());
    }

    public function testTable(): void
    {
        $replace = new Replace();
        $replace->table('foo');
        $this->assertSame('foo', $replace->getTable());
    }

    public function testTable_Exception_ZeroLengthTable(): void
    {
        $this->expectException(ReplaceException::class);
        $this->expectExceptionMessage('Zero length table name');

        $replace = new Replace();
        $replace->table('');
    }

    public function testInsertException(): void
    {
        $this->expectException(InsertException::class);
        $this->expectExceptionMessage('Zero length table name');

        $replace = new Replace();
        $replace->table('');
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

    public function testGetValue(): void
    {
        $replace = new Replace();
        $replace->setValue('foo', 'bar');
        $this->assertSame('bar', $replace->getValue('foo'));
        $replace->setValue('Alice', 'Bob');
        $this->assertSame('Bob', $replace->getValue('Alice'));
    }

    public function testGetValue_Exception_FieldNotSet(): void
    {
        $this->expectException(ReplaceException::class);
        $this->expectExceptionMessage('Field not set: "foo"');

        $replace = new Replace();
        $replace->getValue('foo');
    }
}
