{!! view_render_event('bagisto.shop.products.list.card.before', ['product' => $product]) !!}

<div class="product-card">

    @inject ('productImageHelper', 'Webkul\Product\ProductImage')

    <?php $productBaseImage = $productImageHelper->getProductBaseImage($product); ?>

    @if ($product->new)
        <div class="sticker new">
            {{ __('shop::app.products.new') }}
        </div>
    @endif

    <div class="product-image">
        <a href="{{ route('shop.productOrCategory.index', $product->url_key) }}" title="{{ $product->name }}">
            <img src="{{ $productBaseImage['medium_image_url'] }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'"/>
        </a>

        @foreach (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabel($product->product->id) as $productLabel)
                @include ('productlabelsystem::shop.default.products.list.imagelabelview', ['productLabel' => $productLabel])
        @endforeach
    </div>

    

    <div class="product-information">

        <div class="product-name">
            <a href="{{ route('shop.productOrCategory.index', $product->url_key) }}" title="{{ $product->name }}">
                <span>
                    {{ $product->name }}
                </span>
            </a>
        </div>

        @include ('shop::products.price', ['product' => $product])

        @include('shop::products.add-buttons', ['product' => $product])
    </div>

</div>

{!! view_render_event('bagisto.shop.products.list.card.after', ['product' => $product]) !!}