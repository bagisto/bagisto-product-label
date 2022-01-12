<?php

$productLabel = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabel($productId));
?>
@if($productLabel)
<div class="product-label-image-gallery {{ $productLabel[0]->position }}" title="{{$productLabel[0]->title}}">
    <img src="{{ asset("storage/".$productLabel[0]->image) }}" class="product-label-gallery"/>
</div>
@endif
