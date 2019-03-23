<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemCount;

class ItemTest extends \PHPUnit\Framework\TestCase
{
    function testConstruct()
    {
        $id = ItemId::of(1);
        $name = 'item02';
        $price = \Acme\Shop\Domain\Models\Item\ItemPrice::of(500);
        $stock = \Acme\Shop\Domain\Models\Item\Stock::of(3);

        $sut = new Item($id, $name, $price, $stock);
        $this->assertInstanceOf(Item::class, $sut);
        $this->assertSame($id, $sut->id());
        $this->assertSame($name, $sut->name());
        $this->assertSame($price, $sut->price());
        $this->assertSame($stock, $sut->stock());
    }

    function testIsStockSufficient()
    {
        $id = ItemId::of(1);
        $name = 'item02';
        $price = \Acme\Shop\Domain\Models\Item\ItemPrice::of(500);
        $stock = \Acme\Shop\Domain\Models\Item\Stock::of(3);
        $sut = new Item($id, $name, $price, $stock);

        $this->assertTrue($sut->isStockSufficient(ItemCount::of(2)));
        $this->assertTrue($sut->isStockSufficient(ItemCount::of(3)));
        $this->assertFalse($sut->isStockSufficient(ItemCount::of(4)));
    }

    function testEquals()
    {
        $name = 'item02';
        $price = \Acme\Shop\Domain\Models\Item\ItemPrice::of(500);
        $stock = \Acme\Shop\Domain\Models\Item\Stock::of(3);

        $itemA1 = new Item(ItemId::of(1), $name, $price, $stock);
        $itemA2 = new Item(ItemId::of(1), $name, $price, $stock);
        $itemB = new Item(ItemId::of(2), $name, $price, $stock);

        $this->assertTrue($itemA1->equals($itemA1), 'same instance');
        $this->assertTrue($itemA1->equals($itemA2), 'same id');
        $this->assertFalse($itemA1->equals($itemB), 'not same id');
    }
}
