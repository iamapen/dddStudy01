<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Cart\CartElement;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\Item;

class CartElementTest extends \PHPUnit\Framework\TestCase
{
    use \Acme\Shop\Test\Faker\FakeItem;

    function testConstructor()
    {
        $item = $this->fakeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $this->assertSame($item, $sut->item());
        $this->assertSame($itemCount, $sut->count());
        $this->assertInstanceOf(\Acme\Shop\Domain\Models\Item\ItemSubtotal::class, $sut->price());
        $this->assertSame(500 * 2, $sut->price()->value());
    }

    function testPrice()
    {
        $item = $this->fakeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $itemSubtotal = $sut->price();
        $this->assertInstanceOf(\Acme\Shop\Domain\Models\Item\ItemSubtotal::class, $itemSubtotal);
        $this->assertSame(500 * 2, $itemSubtotal->value());
    }

    function testUpdateCount()
    {
        $item = $this->fakeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $this->assertSame(2, $sut->count()->value());
        $sut->updateCount(ItemCount::of(3));
        $this->assertSame(3, $sut->count()->value());
    }

    function testAddCount()
    {
        $item = $this->fakeItem();
        $itemCount = ItemCount::of(2);
        $sut = new CartElement($item, $itemCount);

        $this->assertSame(2, $sut->count()->value());
        $sut->addCount(ItemCount::of(3));
        $this->assertSame(5, $sut->count()->value());
    }

    function testMatch()
    {
        $item = $this->fakeItem();
        $itemCount = ItemCount::of(2);

        $sut = new CartElement($item, $itemCount);
        $this->assertTrue($sut->match(\Acme\Shop\Domain\Models\Item\ItemId::of(1)));
        $this->assertFalse($sut->match(\Acme\Shop\Domain\Models\Item\ItemId::of(2)));
    }
}
