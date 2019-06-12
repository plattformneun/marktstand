<?php

namespace Marktstand\Product;

use Illuminate\Database\Eloquent\Model;
use Marktstand\Users\Customer;

class Favourite extends Model
{
    /**
     * Set the customer that favor the product.
     *
     * @param  Marktstand\Users\Customer  $customer
     * @return void
     */
    public function setCustomerAttribute(Customer $customer)
    {
        $this->attributes['customer_id'] = $customer->id;
    }

    /**
     * Set a favourite product.
     *
     * @param  Marktstand\Users\Product  $product
     * @return void
     */
    public function setProductAttribute(Product $product)
    {
        $this->attributes['product_id'] = $product->id;
    }
}
