<?php
declare(strict_types=1);

namespace Acme\Shop\Application\UseCases;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartRepository;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemRepository;

/**
 * カートに入れる UseCase
 */
class AddItemToCart
{
    /** @var ItemRepository */
    private $itemRepo;

    /** @var CartRepository */
    private $cartRepo;

    public function __construct(ItemRepository $itemRepo, CartRepository $cartRepo)
    {
        $this->itemRepo = $itemRepo;
        $this->cartRepo = $cartRepo;
    }

    public function __invoke(int $itemId, int $count): Cart
    {
        try {
            $cart = $this->cartRepo->find();
        } catch (NotFoundException $e) {
            $cart = new Cart();
        }

        // 商品が存在しなければ現在のカートを返す
        if (null === $item = $this->itemRepo->findById(ItemId::of($itemId))) {
            return $cart;
        }

        $cart->addItem($item, ItemCount::of($count));
        $this->cartRepo->store($cart);
        return $cart;
    }
}
