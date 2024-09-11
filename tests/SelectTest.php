<?php declare(strict_types=1);

namespace Roka\DML;

use PHPUnit\Framework\TestCase;

final class SelectTest extends TestCase
{
    public function testDefaults(): void
    {
        $select = new Select();
        $this->assertSame(['*'], $select->getFields());
    }

    public function testSetFields(): void
    {
        $select = new Select();
        $select->setFields('foo', 'bar');
        $this->assertSame(['foo', 'bar'], $select->getFields());
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
}
