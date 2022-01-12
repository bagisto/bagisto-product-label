<?php

Route::group(['middleware' => ['web', 'admin']], function () {

    Route::get('/admin/productlabelsystem', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@index')->defaults('_config', [
        'view' => 'productlabelsystem::admin.productlabel.index',
    ])->name('productlabelsystem.admin.productlabel.index');

    Route::get('/admin/productlabelsystem/create', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@create')->defaults('_config', [
        'view' => 'productlabelsystem::admin.productlabel.create',
    ])->name('productlabelsystem.admin.productlabel.create');

    Route::post('/admin/productlabelsystem/create', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@store')->defaults('_config', [
        'redirect' => 'productlabelsystem.admin.productlabel.index',
    ])->name('productlabelsystem.admin.productlabel.store');

    Route::get('/admin/productlabelsystem/edit/{id}', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@edit')->defaults('_config', [
        'view' => 'productlabelsystem::admin.productlabel.edit',
    ])->name('productlabelsystem.admin.productlabel.edit');

    Route::put('/admin/productlabelsystem/edit/{id}', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@update')->defaults('_config', [
        'redirect' => 'productlabelsystem.admin.productlabel.index',
    ])->name('productlabelsystem.admin.productlabel.update');

    Route::post('productlabelsystem/delete/{id}', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@destroy')->name('productlabelsystem.admin.productlabel.delete');

    Route::post('productlabelsystem/masssdelete', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelSystemController@massDestroy')->name('productlabelsystem.admin.productlabel.mass-delete');

  

    // Route::put('/products/edit/{id}', 'Webkul\ProductLabelSystem\Http\Controllers\Admin\ProductLabelImageController@update')->defaults('_config', [
    //     'redirect' => 'admin.catalog.products.index',
    // ])->name('productlabelsystem.admin.productlabelimage.update');

});