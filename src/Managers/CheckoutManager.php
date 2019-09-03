<?php

namespace Marktstand\Managers;

use Marktstand\Users\Customer;
use Marktstand\Product\Product;
use Marktstand\Checkout\Cart\Cart;
use Marktstand\Checkout\Cart\Item;

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
        $item = Item::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ])->first() ?: new Item;

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
        Item::destroy($id);
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
