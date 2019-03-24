<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Item\ItemSubtotal;
use Acme\Shop\Domain\Models\PositiveNumber;

/**
 * カート価格
 */
final class CartTotalPrice extends PositiveNumber
{

    /**
     * @param ItemSubtotal $price
     * @return self
     */
    public function add(ItemSubtotal $price): self
    {
        return self::of($this->value + $price->value());
    }

    /**
     * @return self
     */
    public function clear(): self
    {
        return self::of(0);
    }
}
