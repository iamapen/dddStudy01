<?php
declare(strict_types=1);

namespace Acme\Shop\Test\Faker;

use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemPrice;
use Acme\Shop\Domain\Models\Item\Stock;

trait FakeItem
{
    private function fakeItem(array $opts = []): Item
    {
        $id = ItemId::of($opts['id'] ?? 1);
        $name = $opts['name'] ?? 'item01';
        $price = ItemPrice::of($opts['price'] ?? 500);
        $stock = Stock::of($opts['stock'] ?? 3);

        return new Item($id, $name, $price, $stock);
    }
}
