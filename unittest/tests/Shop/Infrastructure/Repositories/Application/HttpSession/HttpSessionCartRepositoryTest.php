<?php
declare(strict_types=1);

use Acme\Shop\Infrastructure\Repositories\Application\HttpSession\HttpSessionCartRepository;
use Illuminate\Session\Store;
use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Test\SessionHandler\ArraySessionHandler;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Item\ItemCount;

class HttpSessionCartRepositoryTest extends \PHPUnit\Framework\TestCase
{
    use \Acme\Shop\Test\Faker\FakeItem;

    function testFind()
    {
        // セッションにカートがある状態で
        $oldCart = new Cart();
        $oldCart->addItem($this->fakeItem(), ItemCount::of(2));
        $store = new Store('hoge', new ArraySessionHandler());
        $store->put('cart', $oldCart);

        $repo = new HttpSessionCartRepository($store);
        $cart = $repo->find();
        $this->assertSame($oldCart, $cart);
    }

    function testFind_notfound()
    {
        $store = new Store('hoge', new ArraySessionHandler());
        $repo = new HttpSessionCartRepository($store);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('cart not found');
        $repo->find();
    }

    function testStore()
    {
        // セッションにカートがある状態で
        $cart1 = new Cart();
        $cart1->addItem($this->fakeItem(), ItemCount::of(2));
        $store = new Store('hoge', new ArraySessionHandler());
        $store->put('cart', $cart1);

        $repo = new HttpSessionCartRepository($store);

        // find
        $cart2 = $repo->find();
        $this->assertSame($cart1, $cart2);

        // カート更新
        $cart2->addItem($this->fakeItem(['id' => 2]), ItemCount::of(1));
        $repo->store($cart2);

        // 更新されたものが取得できる
        $cart3 = $repo->find();
        $this->assertSame($cart2, $cart3);
    }
}
