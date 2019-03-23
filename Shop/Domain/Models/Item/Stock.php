<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Models\PositiveNumber;

/**
 * 商品在庫
 */
final class Stock extends PositiveNumber
{
    /**
     * 在庫が足りるかどうかを返す
     * @param ItemCount $count
     * @return bool
     */
    public function isSufficient(ItemCount $count): bool
    {
        return ($this->value >= $count->value());
    }
}
