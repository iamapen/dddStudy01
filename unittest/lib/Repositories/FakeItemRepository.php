<?php
declare(strict_types=1);

namespace Acme\Shop\Test\Repositories;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemRepository;
use Acme\Shop\Test\Faker\FakeItem;

class FakeItemRepository implements ItemRepository
{
    use FakeItem;

    public function findById(ItemId $id): ?Item
    {
        if ($id->value() === 999) {
            return null;
        }
        return $this->fakeItem(['id' => $id->value()]);
    }

}
