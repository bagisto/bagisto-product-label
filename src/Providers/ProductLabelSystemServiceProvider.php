<?php

namespace Webkul\ProductLabelSystem\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class ProductLabelSystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'productlabelsystem');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'productlabelsystem');

        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('productlabelsystem::admin.layouts.style');
        });

        $this->publishes([
            __DIR__ . '/../Resources/views/admin/catalog/products/edit.blade.php' => 
            resource_path('views/vendor/admin/catalog/products/edit.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/list/card.blade.php' => 
            resource_path('themes/default/views/products/list/card.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/customers/account/wishlist/wishlist.blade.php' => 
            resource_path('themes/default/views/customers/account/wishlist/wishlist.blade.php'),
        ]);


        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/guest/compare/compare-products.blade.php' => 
            resource_path('themes/default/views/guest/compare/compare-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/view/gallery.blade.php' => 
            resource_path('themes/default/views/products/view/gallery.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/list/card.blade.php' => 
            resource_path('themes/velocity/views/products/list/card.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/list/recently-viewed.blade.php' => 
            resource_path('themes/velocity/views/products/list/recently-viewed.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/checkout/cart/index.blade.php' => 
            resource_path('themes/velocity/views/checkout/cart/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/checkout/cart/index.blade.php' => 
            resource_path('themes/default/views/checkout/cart/index.blade.php'),
        ]);

        

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/views/gallery.blade.php' => 
            resource_path('themes/velocity/views/products/view/gallery.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/home/featured-products.blade.php' => 
            resource_path('themes/velocity/views/home/featured-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/home/new-products.blade.php' => 
            resource_path('themes/velocity/views/home/new-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/guest/compare/compare-products.blade.php' => 
            resource_path('themes/velocity/views/guest/compare/compare-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/guest/wishlist/index.blade.php' => 
            resource_path('themes/velocity/views/guest/wishlist/index.blade.php'),
        ]);

        $this->app->register(EventServiceProvider::class);

       
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }
}