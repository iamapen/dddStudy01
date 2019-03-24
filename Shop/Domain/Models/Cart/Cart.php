<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Exceptions\InvariantException;
use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;
use Illuminate\Support\Collection;

final class Cart
{
    /** @var Collection|CartElement[] */
    private $elements;

    /** @var CartTotalCount */
    private $totalCount;

    /** @var CartTotalPrice */
    private $totalPrice;

    public function __construct()
    {
        $this->clear();
    }

    public function count(): CartTotalCount
    {
        return $this->elements->reduce(function (CartTotalCount $total, CartElement $elem) {
            return $total->add($elem->count());
        }, CartTotalCount::of(0));
    }

    public function price(): CartTotalPrice
    {
        return $this->elements->reduce(function (CartTotalPrice $total, CartElement $elem) {
            return $total->add($elem->price());
        }, CartTotalPrice::of(0));
    }

    public function addItem(Item $item, ItemCount $count)
    {
        if (!$item->isStockSufficient($count)) {
            throw new InvariantException('stock is insufficient');
        }

        $element = $this->findItem($item->id());
        if ($element === null) {
            $element = new CartElement($item, ItemCount::of(0));
            $this->elements->push($element);
        }
        $element->addCount($count);
    }

    public function removeItem(ItemId $id)
    {
        $this->elements = $this->elements->filter(function (CartElement $elem) use ($id) {
            return !$elem->match($id);
        });
    }

    public function updateItemCount(ItemId $id, ItemCount $count) {
        $elem = $this->findItem($id);
        if($elem === null) {
            throw new NotFoundException(sprintf('Item %d is not found', $id->value()));
        }
        $elem->updateCount($count);
    }

    public function clear()
    {
        $this->elements = new Collection();
        $this->totalCount = CartTotalCount::of(0);
        $this->totalPrice = CartTotalPrice::of(0);
    }

    /**
     * @param ItemId $id
     * @return CartElement|null
     */
    private function findItem(ItemId $id): ?CartElement
    {
        return $this->elements->first(function (CartElement $e) use ($id) {
            return $e->match($id);
        }, null);
    }

    public function elements(): Collection
    {
        return clone $this->elements;
    }
}
