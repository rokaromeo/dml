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
}
