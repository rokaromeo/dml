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

    public function testSetFieldsZeroLength(): void
    {
        $this->expectException(SelectException::class);

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

    public function testGetFieldNotSet(): void
    {
        $this->expectException(SelectException::class);

        $select = new Select();
        $select->getField(1);
    }
}
