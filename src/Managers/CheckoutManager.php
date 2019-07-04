<?php

namespace Marktstand\Managers;

use Marktstand\Checkout\Cart;
use Marktstand\Users\Customer;
use Marktstand\Product\Product;
use Marktstand\Checkout\CartItem;

trait CheckoutManager
{
    /**
     * Add a new cart.
     *
     * @param Marktstand\Users\Customer $customer
     * @return Marktstand\Checkout\Cart
     */
    public function addCart(Customer $customer)
    {
        $cart = new Cart;
        $cart->customer_id = $customer->id;
        $cart->save();

        return $cart;
    }

    /**
     * Add a new cart item.
     *
     * @param Marktstand\Checkout\Cart $cart
     * @param  Marktstand\Product\Product $product
     * @param  int $quantity
     * @return Marktstand\Checkout\Cart
     */
    public function addCartItem(Cart $cart, Product $product, int $quantity)
    {
        $item = CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ])->first() ?: new CartItem;

        $producer = $product->producer;

        $this->makeCartItemFillable($item)->fill([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'producer_id' => $producer->id,
            'supplier_id' => $producer->supplier->id,
            'quantity' => $quantity,
        ])->save();

        return $cart;
    }

    /**
     * Set fillable fields for the given checkout item.
     *
     * @param  Marktstand\Checkout\CartItem $item
     * @return Marktstand\Checkout\CartItem
     */
    public function makeCartItemFillable(CartItem $item)
    {
        return $this->setFillable($item, [
            'cart_id', 'product_id', 'producer_id', 'supplier_id', 'quantity',
        ]);
    }
}
