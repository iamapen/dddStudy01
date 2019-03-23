<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\ItemId;

class ItemIdTest extends \Acme\Shop\TestCase\IdentifierTest
{
    protected static $sutClassName = ItemId::class;
}
