<?php
declare(strict_types=1);

namespace Acme\Shop\TestCase;

use Acme\Shop\Domain\Models\PositiveNumber;
use Acme\Shop\Domain\Exceptions\InvariantException;

abstract class PositiveNumberTest extends \PHPUnit\Framework\TestCase
{
    protected static $sutClassName;

    function testConstruct()
    {
        $this->assertInstanceOf(static::$sutClassName, static::$sutClassName::of(5));
        $this->assertInstanceOf(static::$sutClassName, static::$sutClassName::of(0));
    }

    function testConstruct_負数はNG()
    {
        $this->expectException(InvariantException::class);
        static::$sutClassName::of(-1);
    }

    function testValue()
    {
        /* @var $sut PositiveNumber */
        $sut = static::$sutClassName::of(5);
        $this->assertSame(5, $sut->value());
    }

    function testJsonSerialize()
    {
        /* @var $sut PositiveNumber */
        $sut = static::$sutClassName::of(5);
        $this->assertSame(5, $sut->jsonSerialize());
    }
}
