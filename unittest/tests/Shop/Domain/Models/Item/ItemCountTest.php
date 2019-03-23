<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\ItemCount;

class ItemCountTest extends \Acme\Shop\TestCase\PositiveNumberTest
{
    protected static $sutClassName = ItemCount::class;

    function testAdd()
    {
        $sut1 = ItemCount::of(1);
        $sut2 = Itemcount::of(2);
        $this->assertSame(3, $sut1->add($sut2)->value());
        $this->assertSame(1, $sut1->value(), 'immutable');
        $this->assertSame(2, $sut2->value(), 'immutable');
    }
}
