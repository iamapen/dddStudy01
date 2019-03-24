<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\Stock;
use Acme\Shop\Domain\Models\Item\ItemCount;

class StockTest extends \Acme\Shop\Test\TestCase\PositiveNumberTestCase
{
    protected static $sutClassName = Stock::class;

    function testIsSufficient()
    {
        $sut = Stock::of(5);
        $this->assertTrue($sut->isSufficient(ItemCount::of(4)));
        $this->assertTrue($sut->isSufficient(ItemCount::of(5)));
        $this->assertFalse($sut->isSufficient(ItemCount::of(6)));
    }
}
