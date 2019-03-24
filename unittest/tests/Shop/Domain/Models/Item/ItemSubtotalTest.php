<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Item\ItemSubtotal;

class ItemSubtotalTest extends \Acme\Shop\Test\TestCase\PositiveNumberTestCase
{
    protected static $sutClassName = ItemSubtotal::class;
}
