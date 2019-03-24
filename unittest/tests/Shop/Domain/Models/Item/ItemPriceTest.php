<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\ItemPrice;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemSubtotal;

class ItemPriceTest extends \Acme\Shop\Test\TestCase\PositiveNumberTestCase
{
    protected static $sutClassName = ItemPrice::class;

    function testCalcSubtotal() {
        $sut1 = ItemPrice::of(5);
        $subTotal = $sut1->calcSubTotal(ItemCount::of(3));
        $this->assertInstanceOf(ItemSubtotal::class, $subTotal);
        $this->assertSame(15, $subTotal->value());
    }
}
