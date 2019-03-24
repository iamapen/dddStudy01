<?php
declare(strict_types=1);

use Acme\Shop\Infrastructure\Repositories\Domain\ItemDao;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\Item;

class ItemDaoTest extends \Acme\Shop\Test\TestCase\AppDbTestCase
{
    protected function getDataSet()
    {
        $csvDs = new Iamapen\CommentableDataSet\DbUnit\DataSet\CommentableCsvDataSet("\t");
        $csvDs->setIgnoreColumnCount(1);
        $csvDs->addTable('items', self::getFixturesDir() . '/table/items.tsv');
        $ds = new \PHPUnit\DbUnit\DataSet\ReplacementDataSet($csvDs);
        $ds->addFullReplacement('\N', null);
        return $ds;
    }

    function testFindById() {
        $sut = new ItemDao($this->getConnection()->getConnection());

        $item = $sut->findById(ItemId::of(3));
        $this->assertInstanceOf(Item::class, $item);
        $this->assertSame(3, $item->id()->value());

        $this->assertNull($sut->findById(ItemId::of(999)));
    }
}
