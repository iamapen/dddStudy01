<?php
declare(strict_types=1);

use Acme\Shop\Application\UseCases\AddItemToCart;
use Acme\Shop\Infrastructure\Repositories\Domain\ItemDao;
use Acme\Shop\Test\Repositories\ArrayCartRepository;
use Acme\Shop\Test\Repositories\FakeItemRepository;
use Acme\Shop\Domain\Models\Cart\Cart;

class AddItemToCartTest extends \PHPUnit\Framework\TestCase
{
    function testInvoke()
    {
        $itemRepo = new FakeItemRepository();
        $cartRepo = new ArrayCartRepository();
        $uc = new AddItemToCart($itemRepo, $cartRepo);

        $cart = $uc->__invoke(1, 3);
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertSame(3, $cart->count()->value());
    }

    function testInvoke_itemNotfound()
    {
        $itemRepo = new FakeItemRepository();
        $cartRepo = new ArrayCartRepository();
        $uc = new AddItemToCart($itemRepo, $cartRepo);

        $cart = $uc->__invoke(1, 2);
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertSame(2, $cart->count()->value());

        // 商品が存在しない場合は現在のカートがそのまま返る
        $cart = $uc->__invoke(999, 1);
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertSame(2, $cart->count()->value());
    }
}
