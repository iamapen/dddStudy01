<?php
declare(strict_types=1);

namespace Acme\Shop\Test\Repositories;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Cart\Cart;
use Acme\Shop\Domain\Models\Cart\CartRepository;

class ArrayCartRepository implements CartRepository
{
    const SESSION_KEY = 'cart';

    /** @var array */
    private $session;

    public function __construct()
    {
        $this->session = [];
    }

    public function find(): Cart
    {
        if(!isset($this->session[static::SESSION_KEY])) {
            // TODO 例外がいいのかnullがいいのか
            throw new NotFoundException('cart not found');
        }

        $cart = $this->session[static::SESSION_KEY];
        return $cart;
    }

    public function store(Cart $cart): void
    {
        $this->session[static::SESSION_KEY] = $cart;
    }
}
