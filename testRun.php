<?php
/**
 * コントローラの代わり
 *
 * usecase はHTTPに依存していないのでCLIからでも実行できる
 */
declare(strict_types=1);

namespace Acme\Shop;

require __DIR__ . '/vendor/autoload.php';

use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartElement;
use Illuminate\Support\Collection;

$config = getConfig();

// 本来コンテナに乗せておきたいもの
$pdo = new \PDO(
    'mysql:host=127.0.0.1;dbname=dddStudy01;port=3306',
    'dbuser',
    'dbpass',
    $config['pdoOpts']
);

// usecase が使うインフラはここで決めて渡す
// DIコンテナなりRegistryを使う場面
$itemRepo = new Infrastructure\Repositories\Domain\ItemDao($pdo);
$cartRepo = new Test\Repositories\ArrayCartRepository();
$ucAddItemToCart = new Application\UseCases\AddItemToCart($itemRepo, $cartRepo);


// usecase を呼ぶ
echo '* 商品1 を 3個 カートに追加', "\n";
$cart = $ucAddItemToCart->__invoke(1, 3);
echo Collection::make(cartToArray($cart))->toJson($config['debugJsonEncodeOpts']), "\n\n";

echo '* 商品3 を 2個 カートに追加', "\n";
$cart = $ucAddItemToCart->__invoke(3, 2);
echo Collection::make(cartToArray($cart))->toJson($config['debugJsonEncodeOpts']), "\n\n";

exit(0);


/**
 * カートを情報出力用に加工して返す
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

/**
 * 設定を返す
 * @return array
 */
function getConfig()
{
    return [
        'pdoOpts' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_AUTOCOMMIT => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION sql_mode='TRADITIONAL,NO_AUTO_VALUE_ON_ZERO,ONLY_FULL_GROUP_BY'",
        ],
        'debugJsonEncodeOpts' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE,
    ];
}
