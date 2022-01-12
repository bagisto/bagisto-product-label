<link rel="stylesheet" href="{{ asset('themes/default/assets/css/product-label-default.css') }}" />
@if($productLabel)
<div class="default-label-image {{ $productLabel->position }}" title="{{$productLabel->title}}">
    <img src="{{ asset("storage/".$productLabel->image) }}" class="default-label"/>
</div>
@endif
