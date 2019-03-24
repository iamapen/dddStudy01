<?php
declare(strict_types=1);

namespace Acme\Shop\Test\TestCase;

use Acme\Shop\Domain\Models\Identifier;

abstract class IdentifierTestCase extends \PHPUnit\Framework\TestCase
{
    protected static $sutClassName;

    function testConstruct()
    {
        $this->assertInstanceOf(static::$sutClassName, static::$sutClassName::of(5));
    }

    function testValue()
    {
        /* @var $sut Identifier */
        $sut = static::$sutClassName::of(5);
        $this->assertSame(5, $sut->value());
    }

    function testEquals()
    {
        /* @var $one Identifier */
        $one = static::$sutClassName::of(1);
        /* @var $two Identifier */
        $two = static::$sutClassName::of(2);
        $this->assertTrue($one->equals($one));
        $this->assertTrue($one->equals(static::$sutClassName::of(1)));
        $this->assertFalse($one->equals($two));
    }

    function testJsonSerialize()
    {
        /* @var $sut Identifier */
        $sut = static::$sutClassName::of(5);
        $this->assertSame(5, $sut->jsonSerialize());
    }
}
