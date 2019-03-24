<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Item;

interface ItemRepository
{
    /**
     * TODO 戻りはnullableじゃない方がいいのかどうなのか
     * @param ItemId $id
     * @return Item|null
     */
    public function findById(ItemId $id): ?Item;
}
