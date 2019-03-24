<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Cart\CartTotalCount;
use Acme\Shop\Domain\Models\Item\ItemCount;

class CartTotalCountTest extends \Acme\Shop\TestCase\PositiveNumberTest
{
    protected static $sutClassName = CartTotalCount::class;

    function testAdd() {
        $sut = CartTotalCount::of(3);
        $this->assertSame(13, $sut->add(ItemCount::of(10))->value());
    }

    function testClear() {
        $sut = CartTotalCount::of(5);
        $this->assertSame(0, $sut->clear()->value());
    }
}
