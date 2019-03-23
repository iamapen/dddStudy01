<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Models\PositiveNumber;

/**
 * 商品個数
 */
class ItemCount extends PositiveNumber
{
    /**
     * 商品個数を加える
     * @param self $count
     * @return self
     * @throws \Acme\Shop\Domain\Exceptions\InvariantException
     */
    public function add(self $count): self
    {
        return self::of($this->value + $count->value);
    }
}
