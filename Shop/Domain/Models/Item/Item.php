<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Item;

/**
 * 商品 Entity
 *
 * ValueObject導入前
 */
final class Item
{
    /** @var int 商品ID */
    private $id;

    /** @var string 商品名 */
    private $name;

    /** @var int 商品価格 */
    private $price;

    /** @var int 在庫数 */
    private $stock;
}
