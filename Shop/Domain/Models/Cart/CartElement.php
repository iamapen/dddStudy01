<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemSubtotal;

/**
 * カート要素
 */
final class CartElement
{
    /** @var Item */
    private $item;
    /** @var ItemCount */
    private $count;

    public function __construct(Item $item, ItemCount $count)
    {
        $this->item = $item;
        $this->count = $count;
    }

    public function item(): Item
    {
        return $this->item;
    }

    public function count(): ItemCount
    {
        return $this->count;
    }

    public function price(): ItemSubtotal
    {
        return $this->item->price()->calcSubTotal($this->count);
    }

    public function updateCount(ItemCount $count)
    {
        $this->count = $count;
    }

    public function addCount(ItemCount $count)
    {
        $this->count = $this->count->add($count);
    }

    public function match(ItemId $id) :bool
    {
        return $this->item->id()->equals($id);
    }
}
