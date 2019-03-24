<?php
declare(strict_types=1);

use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartElement;
use Illuminate\Support\Collection;

require __DIR__ . '/../../../vendor/autoload.php';

/**
 * コントローラの代わり
 */

$pdoOpts = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_AUTOCOMMIT => false,
    \PDO::MYSQL_ATTR_INIT_COMMAND  => "SET SESSION sql_mode='TRADITIONAL,NO_AUTO_VALUE_ON_ZERO,ONLY_FULL_GROUP_BY'",
];
$pdo = new \PDO(
    'mysql:host=127.0.0.1;dbname=dddStudy01;port=3306',
    'dbuser',
    'dbpass',
    $pdoOpts
);

$ucAddItemToCart = new \Acme\Shop\Application\UseCases\AddItemToCart(
    new \Acme\Shop\Infrastructure\Repositories\Domain\ItemDao($pdo),
    new \Acme\Shop\Test\Repositories\ArrayCartRepository()
);

$jsonOpt = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;

echo '商品1 を 3個 カートに追加', "\n";
$cart = $ucAddItemToCart->__invoke(1, 3);
echo Collection::make(cartToArray($cart))->toJson($jsonOpt), "\n\n";

echo '商品3 を 2個 カートに追加', "\n";
$cart = $ucAddItemToCart->__invoke(3, 2);
echo Collection::make(cartToArray($cart))->toJson($jsonOpt), "\n\n";








/**
 * @param Cart $cart
 * @return array
 */
function cartToArray(Cart $cart): array
{
    $elements = [];
    foreach ($cart->elements() as $cartElement) {
        /** @var CartElement $cartElement */
        $elements[] = [
            'item' => [
                'id' => $cartElement->item()->id(),
                'name' => $cartElement->item()->name(),
                'price' => $cartElement->item()->price(),
            ],
            'count' => $cartElement->count(),
        ];
    }

    return [
        'elements' => $elements,
        'totalCount' => $cart->count(),
        'totalPrice' => $cart->price(),
    ];
}
