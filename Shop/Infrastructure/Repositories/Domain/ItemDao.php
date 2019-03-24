<?php
declare(strict_types=1);

namespace Acme\Shop\Infrastructure\Repositories\Domain;

use Acme\Shop\Domain\Models\Item\ItemPrice;
use Acme\Shop\Domain\Models\Item\ItemRepository;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\Stock;

/**
 * TODO Eloquent版も考える
 */
class ItemDao implements ItemRepository
{
    /** @var \PDO */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param ItemId $id
     * @return Item|null
     */
    public function findById(ItemId $id): ?Item
    {
        $sql = 'SELECT * ';
        $sql .= 'FROM items ';
        $sql .= 'WHERE id = :itemId ';
        $values = ['itemId' => $id->value()];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        if (false === $firstRow = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            // TODO NotFoundExceptionの方がいいのか？
            return null;
        }

        return new Item(
            ItemId::of((int)$firstRow['id']),
            $firstRow['name'],
            ItemPrice::of((int)$firstRow['price']),
            Stock::of((int)$firstRow['stock']),
            );
    }
}
