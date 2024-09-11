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
        $select->join('bar');
        $this->assertSame('foo', $select->getJoin(0));
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
}
