<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Item;

/**
 * 商品 Entity
 */
final class Item
{
    /** @var ItemId 商品ID */
    private $id;

    /** @var string 商品名 */
    private $name;

    /** @var ItemPrice 商品価格 */
    private $price;

    /** @var Stock 在庫数 */
    private $stock;

    /**
     * @param ItemId $id
     * @param string $name
     * @param ItemPrice $price
     * @param Stock $stock
     */
    public function __construct(ItemId $id, string $name, ItemPrice $price, Stock $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    /**
     * 在庫が足りるかどうかを返す
     * @param ItemCount $count
     * @return bool
     */
    public function isStockSufficient(ItemCount $count): bool
    {
        return $this->stock()->isSufficient($count);
    }

    public function id(): ItemId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): ItemPrice
    {
        return $this->price;
    }

    public function stock(): Stock
    {
        return $this->stock;
    }

    /**
     * @param self $item
     * @return bool
     */
    public function equals(self $item): bool
    {
        return $this->id()->equals($item->id());
    }
}
