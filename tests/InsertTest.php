<?php declare(strict_types=1);

namespace Roka\DML;

use PHPUnit\Framework\TestCase;

final class InsertTest extends TestCase
{
    public function testDefaults(): void
    {
        $insert = new Insert();
        $this->assertSame([], $insert->getFields());
        $this->assertSame(false, $insert->hasField());
        $this->assertSame(false, $insert->hasField('foo'));
        $this->assertSame([], $insert->getValues());
    }

    public function testTable(): void
    {
        $insert = new Insert();
        $insert->table('foo');
        $this->assertSame('foo', $insert->getTable());
    }

    public function testTable_Exception_ZeroLengthTable(): void
    {
        $this->expectException(InsertException::class);
        $this->expectExceptionMessage('Zero length table name');

        $insert = new Insert();
        $insert->table('');
    }

    public function testSetValue(): void
    {
        $insert = new Insert();
        $insert->setValue('foo', 'bar');
        $this->assertSame(['foo'], $insert->getFields());
        $this->assertSame(true, $insert->hasField());
        $this->assertSame(true, $insert->hasField('foo'));
        $this->assertSame([['foo' => 'bar']], $insert->getValues());

        $insert->setValue('Alice', 'Bob');
        $this->assertSame(['foo', 'Alice'], $insert->getFields());
        $this->assertSame(true, $insert->hasField('Alice'));
        $this->assertSame([['foo' => 'bar', 'Alice' => 'Bob']], $insert->getValues());
    }

    public function testSetValue_Exception_ZeroLengthFieldName(): void
    {
        $this->expectException(InsertException::class);
        $this->expectExceptionMessage('Zero length field name');

        $insert = new Insert();
        $insert->setValue('', 'bar');
    }

    // public function testSetValues(): void
    // {
    //     $insert = new Insert();
    //     $insert->setValues(['foo' => 'bar', 'foo2' => 'bar2']);
    //     $this->assertSame(['foo' => 'bar', 'foo2' => 'bar2'], $insert->getValues());
    // }
}
