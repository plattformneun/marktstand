<?php

namespace Marktstand\Managers;

use Marktstand\Checkout\Cart;
use Marktstand\Users\Customer;
use Marktstand\Product\Product;
use Marktstand\Checkout\CartItem;

class CheckoutManager extends Manager
{
    /**
     * Create a new cart.
     *
     * @param Marktstand\Users\Customer $customer
     * @return Marktstand\Checkout\Cart
     */
    public function createCart(Customer $customer)
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
    public function addToCart(Cart $cart, Product $product, int $quantity)
    {
        $item = CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ])->first() ?: new CartItem;

        $producer = $product->producer;

        $this->makeFillable($item)->fill([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'producer_id' => $producer->id,
            'supplier_id' => $producer->supplier->id,
            'quantity' => $quantity,
        ])->save();

        return $cart;
    }

    /**
     * Remove a cart item.
     *
     * @param  int $id
     * @return void
     */
    public function removeFromCart($id)
    {
        CartItem::destroy($id);
    }

    /**
     * Set the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'cart_id', 'product_id', 'producer_id', 'supplier_id', 'quantity',
        ];
    }
}
