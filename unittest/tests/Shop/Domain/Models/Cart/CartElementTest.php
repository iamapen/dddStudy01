<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Cart\CartElement;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\Item;

class CartElementTest extends \PHPUnit\Framework\TestCase
{
    function makeItem()
    {
        $itemId = \Acme\Shop\Domain\Models\Item\ItemId::of(1);
        $itemName = 'item02';
        $itemPrice = \Acme\Shop\Domain\Models\Item\ItemPrice::of(500);
        $itemStock = \Acme\Shop\Domain\Models\Item\Stock::of(3);
        return new Item($itemId, $itemName, $itemPrice, $itemStock);
    }

    function testConstructor()
    {
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $this->assertSame($item, $sut->item());
        $this->assertSame($itemCount, $sut->count());
        $this->assertInstanceOf(\Acme\Shop\Domain\Models\Item\ItemSubtotal::class, $sut->price());
        $this->assertSame(500 * 2, $sut->price()->value());
    }

    function testPrice()
    {
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $itemSubtotal = $sut->price();
        $this->assertInstanceOf(\Acme\Shop\Domain\Models\Item\ItemSubtotal::class, $itemSubtotal);
        $this->assertSame(500 * 2, $itemSubtotal->value());
    }

    function testUpdateCount()
    {
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $this->assertSame(2, $sut->count()->value());
        $sut->updateCount(ItemCount::of(3));
        $this->assertSame(3, $sut->count()->value());
    }

    function testAddCount()
    {
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $this->assertSame(2, $sut->count()->value());
        $sut->addCount(ItemCount::of(3));
        $this->assertSame(5, $sut->count()->value());
    }

    function testMatch()
    {
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);

        $sut = new CartElement($item, $itemCount);
        $this->assertTrue($sut->match(\Acme\Shop\Domain\Models\Item\ItemId::of(1)));
        $this->assertFalse($sut->match(\Acme\Shop\Domain\Models\Item\ItemId::of(2)));
    }
}
