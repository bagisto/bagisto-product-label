@push('css')
<style>
  .product-label-image {  
    height: 30px;
    width: 30px;
    position: absolute;
  }

  .product-label {
    width: 30px;
    height: 30px;
  }
  .Top-Left
  {
      left: 0;
      top: 5px;
  }

  .Top-Right
  {
      right: 0;
      top: 5px;
  }
  .Bottom-Left
  {
      left: 0;
      bottom: 5px;
  }
  .Bottom-Right
  {
      right: 0;
      bottom: 5px;
  }
  .None
  {
      display: none;
  }
</style>
@endpush
<?php
$productLabel = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabel($item))
?>

<div class="product-label-wishlist {{ $productLabel[0]->position }}" title="{{$productLabel[0]->title}}">
    <img src="{{ asset("storage/".$productLabel[0]->image) }}" class="product-label"/>
</div>
