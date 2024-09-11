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
        $this->assertSame(0, $insert->getRowCount());
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
        $this->assertSame(1, $insert->getRowCount());

        $insert->setValue('Alice', 'Bob');
        $this->assertSame(['foo', 'Alice'], $insert->getFields());
        $this->assertSame(true, $insert->hasField('Alice'));
        $this->assertSame([['foo' => 'bar', 'Alice' => 'Bob']], $insert->getValues());
        $this->assertSame(1, $insert->getRowCount());
    }

    public function testSetValue_Exception_ZeroLengthFieldName(): void
    {
        $this->expectException(InsertException::class);
        $this->expectExceptionMessage('Zero length field name');

        $insert = new Insert();
        $insert->setValue('', 'bar');
    }

    public function testSetValues(): void
    {
        $insert = new Insert();
        $insert->setValues(['foo' => 'bar', 'Alice' => 'Bob']);
        $this->assertSame([['foo' => 'bar', 'Alice' => 'Bob']], $insert->getValues());
        $this->assertSame(['foo' => 'bar', 'Alice' => 'Bob'], $insert->getValues(0));
        $this->assertSame(1, $insert->getRowCount());

        // Overwrite
        $insert->setValues(['foo' => 'row2_column1', 'Alice' => 'row2_column2']);
        $this->assertSame([['foo' => 'row2_column1', 'Alice' => 'row2_column2']], $insert->getValues());
        $this->assertSame(['foo' => 'row2_column1', 'Alice' => 'row2_column2'], $insert->getValues(0));
        $this->assertSame(['foo', 'Alice'], $insert->getFields());
        $this->assertSame(1, $insert->getRowCount());

        $insert = new Insert();
        $insert->setValues([
                    ['foo' => 'bar',          'Alice' => 'Bob'],
                    ['foo' => 'row2_column1', 'Alice' => 'row2_column2']
                ]);
        $this->assertSame([
                    ['foo' => 'bar',          'Alice' => 'Bob'],
                    ['foo' => 'row2_column1', 'Alice' => 'row2_column2']
                ], $insert->getValues());
        $this->assertSame(['foo' => 'bar',          'Alice' => 'Bob'], $insert->getValues(0));
        $this->assertSame(['foo' => 'row2_column1', 'Alice' => 'row2_column2'], $insert->getValues(1));
        $this->assertSame(['foo', 'Alice'], $insert->getFields());
        $this->assertSame(2, $insert->getRowCount());
    }

    public function testGetValues_Exception_RowNotSet(): void
    {
        $this->expectException(InsertException::class);
        $this->expectExceptionMessage('Row is not set: "0"');

        $insert = new Insert();
        $insert->getValues(0);
    }

    public function testOnDuplicateKeyUpdate(): void
    {
        $insert = new Insert();
        $insert->setValues(['foo' => 'bar', 'Alice' => 'Bob']);
        $insert->onDuplicateKeyUpdate('foo');
        $this->assertSame(['foo' => 'values(`foo`)'], $insert->getOnDuplicateKeyUpdate());
        $insert->onDuplicateKeyUpdate('Alice');
        $this->assertSame(['Alice' => 'values(`Alice`)'], $insert->getOnDuplicateKeyUpdate());
        $insert->onDuplicateKeyUpdate('foo', 'Alice');
        $this->assertSame(['foo' => 'values(`foo`)', 'Alice' => 'values(`Alice`)'], $insert->getOnDuplicateKeyUpdate());

        $insert = new Insert();
        $insert->setValues(['foo' => 'bar', 'Alice' => 'Bob']);
        $insert->onDuplicateKeyUpdate(['foo' => 'BAR']);
        $this->assertSame(['foo' => 'BAR'], $insert->getOnDuplicateKeyUpdate());
        $insert->onDuplicateKeyUpdate(['Alice' => 'BOB']);
        $this->assertSame(['Alice' => 'BOB'], $insert->getOnDuplicateKeyUpdate());
        $insert->onDuplicateKeyUpdate(['foo' => 'BAR', 'Alice' => 'BOB']);
        $this->assertSame(['foo' => 'BAR', 'Alice' => 'BOB'], $insert->getOnDuplicateKeyUpdate());
    }

    public function testOnDuplicateKeyUpdate_Exception_FieldNotSet(): void
    {
        $this->expectException(InsertException::class);
        $this->expectExceptionMessage('Field is not set: "foo"');

        $insert = new Insert();
        $insert->onDuplicateKeyUpdate('foo');
    }
}
