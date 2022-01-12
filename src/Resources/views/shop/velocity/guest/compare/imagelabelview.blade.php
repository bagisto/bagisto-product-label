
<?php
$productLabel = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabel($item))
?>

<div class="product-label-image-compare {{ $productLabel[0]->position }}" title="{{$productLabel[0]->title}}">
    <img src="{{ asset("storage/".$productLabel[0]->image) }}" class="product-label-compare"/>
</div>
