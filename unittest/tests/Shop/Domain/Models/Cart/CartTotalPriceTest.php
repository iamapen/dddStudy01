<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Cart\CartTotalPrice;
use Acme\Shop\Domain\Models\Item\ItemSubtotal;

class CartTotalPriceTest extends \Acme\Shop\Test\TestCase\PositiveNumberTestCase
{
    protected static $sutClassName = CartTotalPrice::class;

    function testAdd() {
        $sut = CartTotalPrice::of(1000);
        $this->assertSame(1150, $sut->add(ItemSubtotal::of(150))->value());
    }

    function testClear() {
        $sut = CartTotalPrice::of(1000);
        $this->assertSame(0, $sut->clear()->value());
    }
}
