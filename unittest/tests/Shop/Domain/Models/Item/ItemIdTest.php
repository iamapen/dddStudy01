<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\ItemId;

class ItemIdTest extends \Acme\Shop\Test\TestCase\IdentifierTestCase
{
    protected static $sutClassName = ItemId::class;
}
