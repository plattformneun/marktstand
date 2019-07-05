<?php

namespace Marktstand;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapRelations();

        $this->publishes([
            $this->path('config/marktstand.php') => config_path('marktstand.php'),
        ]);

        $this->loadMigrationsFrom(
            $this->path('database/migrations')
        );
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->path('config/marktstand.php'), 'marktstand');

        $this->app->bind('marktstand', function () {
            return new Marktstand;
        });
    }

    /**
     * Map polymorphic relations.
     *
     * @return void
     */
    protected function mapRelations()
    {
        Relation::morphMap([
            'cart' => \Marktstand\Checkout\Cart::class,
            'order' => \Marktstand\Checkout\Order::class,
            'customer' => \Marktstand\Users\Customer::class,
            'producer' => \Marktstand\Users\Producer::class,
            'product' => \Marktstand\Product\Product::class,
        ]);
    }

    /**
     * Get the full path.
     *
     * @param  string $path
     * @return string
     */
    protected function path(string $path)
    {
        return __DIR__.'//..//'.$path;
    }
}
