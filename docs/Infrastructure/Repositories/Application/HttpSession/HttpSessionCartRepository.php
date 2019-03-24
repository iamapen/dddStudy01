<?php
declare(strict_types=1);

namespace Acme\Shop\Infrastructure\Repositories\Application\HttpSession;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartRepository;
use Illuminate\Session\Store;

final class HttpSessionCartRepository implements CartRepository
{
    const SESSION_KEY = 'cart';

    /** @var Store */
    private $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function find(): Cart
    {
        $cart = $this->session->get(static::SESSION_KEY);
        if($cart === null) {
            // TODO 例外がいいのかnullがいいのか
            throw new NotFoundException('cart not found');
        }
        return $cart;
    }

    public function store(Cart $cart): void
    {
        $this->session->put(static::SESSION_KEY, $cart);
    }
}
