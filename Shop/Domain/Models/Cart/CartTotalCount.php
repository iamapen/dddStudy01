<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\PositiveNumber;

/**
 * カート商品数
 */
final class CartTotalCount extends PositiveNumber
{

    /**
     * @param ItemCount $number
     * @return self
     */
    public function add(ItemCount $number): self
    {
        return self::of($this->value + $number->value());
    }

    /**
     * @return self
     */
    public function clear(): self
    {
        return self::of(0);
    }
}
