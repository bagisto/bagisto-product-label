@push('css')
<link rel="stylesheet" href="{{ asset('themes/default/assets/css/product-label-default.css') }}" />
@endpush
<?php

$productLabel = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabel($item));

?>

<div class="default-label-image-wishlist {{ $productLabel[0]->position }}" title="{{$productLabel[0]->title}}">
    <img src="{{ asset("storage/".$productLabel[0]->image) }}" class="default-label-wishlist"/>
</div>
