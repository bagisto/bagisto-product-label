<?php

namespace Webkul\ProductLabelSystem\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('catalog.product.update.after', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@afterProductCreatedUpdated');
        Event::listen('bagisto.admin.catalog.product.edit.before', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@editFormProduct');
        
        Event::listen('bagisto.shop.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('productlabelsystem::shop.style');
        });

    }
}