<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Models\PositiveNumber;

/**
 * 商品価格
 */
class ItemPrice extends PositiveNumber
{

    /**
     * 商品小計を計算して返す
     * @param ItemCount $count
     * @return ItemSubtotal
     * @throws \Acme\Shop\Domain\Exceptions\InvariantException
     */
    public function calcSubTotal(ItemCount $count): ItemSubtotal
    {
        return ItemSubtotal::of($this->value * $count->value);
    }
}
