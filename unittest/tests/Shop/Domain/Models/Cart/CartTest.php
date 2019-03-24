<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartElement;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\Item;

class CartTest extends \PHPUnit\Framework\TestCase
{
    function makeItem()
    {
        $itemId = \Acme\Shop\Domain\Models\Item\ItemId::of(1);
        $itemName = 'item02';
        $itemPrice = \Acme\Shop\Domain\Models\Item\ItemPrice::of(500);
        $itemStock = \Acme\Shop\Domain\Models\Item\Stock::of(3);
        return new Item($itemId, $itemName, $itemPrice, $itemStock);
    }

    function makeElement() {
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);
        return new CartElement($item, $itemCount);
    }

    function testConstructor()
    {
        $sut = new Cart();
        $this->assertSame(0, $sut->count()->value());
        $this->assertSame(0, $sut->price()->value());
    }

    function testAddItem() {
        $cart = new Cart();
        $this->assertSame(0, $cart->count()->value());
        $this->assertSame(0, $cart->price()->value());

        $cart->addItem($this->makeItem(), ItemCount::of(2));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());

        $cart->addItem($this->makeItem(), ItemCount::of(1));
        $this->assertSame(3, $cart->count()->value());
        $this->assertSame(1500, $cart->price()->value());
    }

    function testAddItem_在庫なし() {
        $this->expectException(\Acme\Shop\Domain\Exceptions\InvariantException::class);
        $this->expectExceptionMessage('stock is insufficient');
        $cart = new Cart();
        $cart->addItem($this->makeItem(), ItemCount::of(4));
    }

    function testRemoveItem() {
        $cart = new Cart();
        $this->assertSame(0, $cart->count()->value());
        $this->assertSame(0, $cart->price()->value());

        $cart->addItem($this->makeItem(), ItemCount::of(2));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());

        $cart->removeItem(\Acme\Shop\Domain\Models\Item\ItemId::of(5));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());

        $cart->removeItem(\Acme\Shop\Domain\Models\Item\ItemId::of(1));
        $this->assertSame(0, $cart->count()->value());
        $this->assertSame(0, $cart->price()->value());
    }

    function testUpdateItemCount() {
        $cart = new Cart();
        $cart->addItem($this->makeItem(), ItemCount::of(2));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());

        $cart->updateItemCount(\Acme\Shop\Domain\Models\Item\ItemId::of(1), ItemCount::of(3));
        $this->assertSame(3, $cart->count()->value());
        $this->assertSame(1500, $cart->price()->value());
    }

    function testUpdateItemCount_notfound() {
        $this->expectException(\Acme\Shop\Domain\Exceptions\NotFoundException::class);
        $this->expectExceptionMessage('Item 5 is not found');

        $cart = new Cart();
        $cart->addItem($this->makeItem(), ItemCount::of(2));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());

        $cart->updateItemCount(\Acme\Shop\Domain\Models\Item\ItemId::of(5), ItemCount::of(3));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());
    }

    function testClear() {
        $cart = new Cart();
        $this->assertSame(0, $cart->count()->value());
        $this->assertSame(0, $cart->price()->value());

        $cart->addItem($this->makeItem(), ItemCount::of(2));
        $this->assertSame(2, $cart->count()->value());
        $this->assertSame(1000, $cart->price()->value());

        $cart->clear();
        $this->assertSame(0, $cart->count()->value());
        $this->assertSame(0, $cart->price()->value());
    }

    function testElements() {
        $cart = new Cart();
        $item = $this->makeItem();
        $itemCount = ItemCount::of(2);
        $cart->addItem($item, $itemCount);

        $result = $cart->elements();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);

        /* @var $elem1 CartElement */
        $elem1 = $result->all()[0];
        $this->assertSame($item, $elem1->item());   // deep copyするべき？
        $this->assertNotSame($itemCount, $elem1->count());
        $this->assertEquals($itemCount, $elem1->count());
    }
}
