<?php

namespace Webkul\ProductLabelSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\ProductLabelSystem\Contracts\ProductLabelImage as ProductLabelImageContract;
use Webkul\ProductLabelSystem\Models\ProductLabelImageProxy;
use Webkul\Product\Models\ProductProxy;

class ProductLabelImage extends Model implements ProductLabelImageContract
{
    //
    protected $fillable = [
        'product_id',
        'custom_label_id',
        'product_url_key',
    ];

    public function productLabel()
    {
        //return $this->belongsTo(ProductProxy::modelClass());
        return $this->hasOne('Webkul\Product\Models\Product', 'foreign_key');
    }

    public function getImageLabel()
    {
        return $this->product->custom_label_id;
    }

    public function getTypeInstance()
    {
        return $this->product->getTypeInstance();
    }
    
    public function productLabelImages()
    { 
        return (ProductLabelImageProxy::modelClass())
            ::where('product_label_images.product_id', $this->product_id)
            ->select('product_label_images.*');
    }

    public function getproductLabelImagesAttribute()
    {
        return $this->productLabelImages()->get();
    }
}
