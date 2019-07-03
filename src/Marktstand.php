<?php

namespace Marktstand;

class Marktstand
{
    /**
     * Register a new customer.
     *
     * @param  array $data
     * @return Marktstand\Users\Customer
     */
    public function registerCustomer(array $data)
    {
        return $this->fillUser(new Users\Customer, $data);
    }

    /**
     * Register a new producer.
     *
     * @param  array $data
     * @return Marktstand\Users\Producer
     */
    public function registerProducer(array $data)
    {
        return $this->fillUser(new Users\Producer, $data);
    }

    /**
     * Fill a user with data.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function fillUser($user, array $data)
    {
        $this->makeUserFillable($user)
            ->fill($data)
            ->save();

        return $user;
    }

    /**
     * Update a user.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @param  array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateUser($user, array $data)
    {
        $this->makeUserFillable($user)
            ->update($data);

        return $user;
    }

    /**
     * Add a new address.
     *
     * @param object $owner
     * @param array $data
     * @return bool
     */
    public function addAddress($owner, array $data)
    {
        $address = new Support\Address;
        
        $this->makeAddressFillable($address)->fill(array_merge($data, [
            'owner_id' => $owner->id,
            'owner_type' => $owner->type,
        ]))->save();

        return $address;
    }

    /**
     * Add a new bank account.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return bool
     */
    public function addBankAccount($user, array $data)
    {
        return $this->makeBankAccountFillable(new Payment\BankAccount)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();
    }

    /**
     * Add a new company.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return Marktstand\Company\Company
     */
    public function addCompany($user, array $data)
    {
        $company = new Company\Company;

        $this->makeCompanyFillable($company)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $company;
    }

    /**
     * Update the given company.
     *
     * @param  Marktstand\Company\Company $company
     * @param  array $data
     * @return Marktstand\Company\Company
     */
    public function updateCompany(Company\Company $company, array $data)
    {
        $this->makeCompanyFillable($company)
            ->update($data);

        return $company;
    }

    /**
     * Add a new supplier.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return Marktstand\Users\Supplier
     */
    public function addSupplier($user, array $data)
    {
        $supplier = new Users\Supplier;

        $this->makeSupplierFillable($supplier)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $supplier;
    }

    /**
     * Update a supplier.
     *
     * @param Marktstand\Users\Supplier
     * @param array $data
     * @return Marktstand\Users\Supplier
     */
    public function updateSupplier(Users\Supplier $supplier, array $data)
    {
        $this->makeSupplierFillable($supplier)->update($data);

        return $supplier;
    }

    /**
     * Add a new cart.
     *
     * @param Marktstand\Users\Customer $customer
     * @return Marktstand\Checkout\Cart
     */
    public function addCart(Users\Customer $customer)
    {
        $cart = new Checkout\Cart;
        $cart->customer_id = $customer->id;
        $cart->save();

        return $cart;
    }

    /**
     * Add a new cart.
     *
     * @param Marktstand\Checkout\Cart $cart
     * @param  Marktstand\Product\Product $product
     * @param  int $quantity
     * @return Marktstand\Checkout\Cart
     */
    public function addCartItem(Checkout\Cart $cart, Product\Product $product, int $quantity)
    {
        $item = Checkout\CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ])->first() ?: new Checkout\CartItem;

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
     * Add a new contact.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return Marktstand\Company\Contact
     */
    public function addContact($user, array $data)
    {
        $contact = new Company\Contact;

        $this->makeContactFillable($contact)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $contact;
    }

    /**
     * Update the given contact.
     *
     * @param  Marktstand\Company\Contact $contact
     * @param  array $data
     * @return Marktstand\Company\Contact
     */
    public function updateContact(Company\Contact $contact, array $data)
    {
        $this->makeContactFillable($contact)
            ->update($data);

        return $contact;
    }

    /**
     * Add a new product category.
     *
     * @param array $data
     * @return Marktstand\Product\Category
     */
    public function addCategory(array $data)
    {
        $category = new Product\Category;

        $this->makeCategoryFillable($category)
            ->fill($data)
            ->save();

        return $category;
    }

    /**
     * Add a new favourite.
     *
     * @param array $data
     * @return Marktstand\Product\Favourite
     */
    public function addFavourite(array $data)
    {
        $favourite = new Product\Favourite;

        $this->makeCategoryFillable($favourite)
            ->fill($data)
            ->save();

        return $favourite;
    }

    /**
     * Add a new product.
     *
     * @param Marktstand\Users\Producer $producer
     * @param array $data
     * @return Marktstand\Product\Product
     */
    public function addProduct(Users\Producer $producer, array $data)
    {
        $product = new Product\Product;

        $this->makeProductFillable($product)->fill(array_merge($data, [
            'producer_id' => $producer->id,
        ]))->save();

        return $product;
    }

    /**
     * Update the given product.
     *
     * @param  Marktstand\Product\Product $product
     * @param  array $data
     * @return Marktstand\Product\Product
     */
    public function updateProduct(Product\Product $product, array $data)
    {
        $this->makeProductFillable($product)
            ->update($data);

        return $product;
    }

    /**
     * Add a new image.
     *
     * @param array $data
     * @param mixed $owner
     * @param Marktstand\Support\Image|null $image
     * @return  Marktstand\Support\Image
     */
    public function addImage($data, $owner = null, $image = null)
    {
        $image = $image ?: new Support\Image;

        $this->makeImageFillable($image)
            ->fill($data);

        if ($owner) {
            $this->attachImage($image, $owner);
        }

        $image->save();

        return $image;
    }

    /**
     * Attach an image to the given owner.
     *
     * @param Marktstand\Support\Image $image
     * @param mixed $owner
     * @return  Marktstand\Support\Image
     */
    public function attachImage($image, $owner)
    {
        return $this->makeImageFillable($image)->fill([
            'imageable_id' => $owner->id,
            'imageable_type' => $owner_type,
        ]);
    }

    /**
     * Attach an image to the given owner and save.
     *
     * @param Marktstand\Support\Image $image
     * @param mixed $owner
     * @return  Marktstand\Support\Image
     */
    public function attachImageAndSave($image, $owner)
    {
        $this->attachImage($image, $owner);

        $image->save();

        return $image;
    }

    /**
     * Add a new product image.
     *
     * @param Marktstand\Product\Product $product
     * @param array  $data
     * @return Marktstand\Support\Image
     */
    public function addProductImage(Product\Product $product, $data)
    {
        return $this->addImage($data, $product, $product->image);
    }

    /**
     * Set fillable fields for the given user.
     *
     * @param  Illuminate\Database\Eloquent\Model $user
     * @return Illuminate\Database\Eloquent\Model
     */
    public function makeUserFillable($user)
    {
        return $this->setFillable($user, [
            'email', 'firstname', 'lastname', 'password', 'username', 'options'
        ]);
    }

    /**
     * Set fillable fields for the given bank account.
     *
     * @param  Marktstand\Support\Address $address
     * @return Marktstand\Support\Address
     */
    public function makeAddressFillable(Support\Address $address)
    {
        return $this->setFillable($address, [
            'recipient', 'street', 'house', 'post_code', 'city', 'country', 'owner_id', 'owner_type',
        ]);
    }

    /**
     * Set fillable fields for the given bank account.
     *
     * @param  Marktstand\Payment\BankAccount $account
     * @return Marktstand\Payment\BankAccount
     */
    public function makeBankAccountFillable(Payment\BankAccount $account)
    {
        return $this->setFillable($account, [
            'holder', 'number', 'code', 'user_id', 'user_type',
        ]);
    }

    /**
     * Set fillable fields for the given checkout item.
     *
     * @param  Marktstand\Checkout\CartItem $item
     * @return Marktstand\Checkout\CartItem
     */
    public function makeCartItemFillable(Checkout\CartItem $item)
    {
        return $this->setFillable($item, [
            'cart_id', 'product_id', 'producer_id', 'supplier_id', 'quantity'
        ]);
    }

    /**
     * Set fillable fields for the given company.
     *
     * @param  Marktstand\Company\Company $company
     * @return Marktstand\Company\Company
     */
    public function makeCompanyFillable(Company\Company $company)
    {
        return $this->setFillable($company, [
            'name', 'legal_form', 'description', 'street', 'house', 'post_code', 'city', 'country', 'vat_id', 'user_id', 'user_type', 'profile_image', 'title_image',
        ]);
    }

    /**
     * Set fillable fields for the given contact.
     *
     * @param  Marktstand\Company\Contact $contact
     * @return Marktstand\Company\Contact
     */
    public function makeContactFillable(Company\Contact $contact)
    {
        return $this->setFillable($contact, [
            'position', 'gender', 'firstname', 'lastname', 'email', 'user_id', 'user_type',
        ]);
    }

    /**
     * Set fillable fields for the given category.
     *
     * @param  Marktstand\Product\Category $category
     * @return Marktstand\Product\Category
     */
    public function makeCategoryFillable(Product\Category $category)
    {
        return $this->setFillable($category, [
            'title',
        ]);
    }

    /**
     * Set fillable fields for the given favourite.
     *
     * @param  Marktstand\Product\Favourite $favourite
     * @return Marktstand\Product\Favourite
     */
    public function makeFavouriteFillable(Product\Favourite $favourite)
    {
        return $this->setFillable($favourite, [
            'customer', 'product', 'customer_id', 'product_id',
        ]);
    }

    /**
     * Set fillable fields for the given image.
     *
     * @param  Marktstand\Support\Image $image
     * @return Marktstand\Support\Image
     */
    public function makeImageFillable(Support\Image $image)
    {
        return $this->setFillable($image, [
            'name', 'bucket', 'imageable_id', 'imageable_type',
        ]);
    }

    /**
     * Set fillable fields for the given product.
     *
     * @param  Marktstand\Product\Product $product
     * @return Marktstand\Product\Product
     */
    public function makeProductFillable(Product\Product $product)
    {
        return $this->setFillable($product, [
            'visibillity',
            'title',
            'description',
            'characteristic',
            'article_number',
            'image_id',
            'unit',
            'volume',
            'volume_unit',
            'price',
            'price_unit',
            'vat',
            'packaging',
            'ingredients',
            'expiration',
            'lead_time',
            'deposit',
            'producer_id',
        ]);
    }

    /**
     * Set fillable fields for the given supplier.
     *
     * @param  Marktstand\Users\Supplier $supplier
     * @return Marktstand\Users\Supplier
     */
    public function makeSupplierFillable(Users\Supplier $supplier)
    {
        return $this->setFillable($supplier, [
            'charge', 'free_shipping_at', 'delivery_times', 'min_order_value', 'user_id', 'user_type'
        ]);
    }

    /**
     * Set fillable fields for the given model.
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     * @param  array  $fillable
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setFillable($model, array $fillable)
    {
        return $model->fillable($fillable);
    }
}
