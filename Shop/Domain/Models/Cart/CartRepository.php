<?php
declare(strict_types=1);

namespace Acme\Shop\Domain\Models\Cart;

interface CartRepository
{

    /**
     * @return Cart
     */
    public function find(): Cart;

    /**
     * @param Cart $cart
     */
    public function store(Cart $cart): void;
}
