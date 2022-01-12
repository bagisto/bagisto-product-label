<?php
$productLabel = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabel($productId))
?>
<div class="product-label-image-wishlist {{ $productLabel[0]->position }}" title="{{$productLabel[0]->title}}">
    <img src="{{ asset("storage/".$productLabel[0]->image) }}" class="product-label-wishlist"/>
</div>