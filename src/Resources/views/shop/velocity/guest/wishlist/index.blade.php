@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.wishlist.page-title') }}
@endsection

@php
    $productLabels = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getAllProductsLabel());
@endphp
@push('css')
<style>
    .product-label-image {
        height: 50px;
        width: 50px;
        position: absolute;
    }
    .product-label {
        width: 50px;
        height: 50px;
    }
    .Top-Left{
        left: 0;
        top: 10%;
    }
    .Top-Right{
        right: 0;
        top: 10%;
    }
    .Bottom-Left{
        left: 0;
        top: 40%;
    }
    .Bottom-Right{    
        top: 40%;
        right: 0;
    }
    .None{
        display: none;
    }
</style>
@endpush

@section('content-wrapper')
    @guest('customer')
        <wishlist-product></wishlist-product>
    @endguest

    @auth('customer')
        @push('scripts')
            <script>
                window.location = '{{ route('customer.wishlist.index') }}';
            </script>
        @endpush
    @endauth
@endsection

@push('scripts')
    <script type="text/x-template" id="wishlist-product-template">
        <section class="cart-details row no-margin col-12">
            <h1 class="fw6 col-6">
                {{ __('shop::app.customer.account.wishlist.title') }}
            </h1>

            <div class="col-6" v-if="products.length > 0">
                <button
                    class="theme-btn light pull-right"
                    @click="removeProduct('all')">
                    {{ __('shop::app.customer.account.wishlist.deleteall') }}
                </button>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.guest-customer.view.before') !!}

            <div class="row products-collection col-12 ml0">
                <shimmer-component v-if="!isProductListLoaded && !isMobile()"></shimmer-component>

                <template v-else-if="isProductListLoaded && products.length > 0">
                    <carousel-component
                        slides-per-page="6"
                        navigation-enabled="hide"
                        pagination-enabled="hide"
                        id="wishlist-products-carousel"
                        locale-direction="{{ core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr' }}"
                        :slides-count="products.length">

                        <slide
                            :key="index"
                            :slot="`slide-${index}`"
                            v-for="(product, index) in products">
                            
                            
                            <div class="card grid-card product-card-new">
                                
                                    <a :title="product.name" :href="`${baseUrl}/${product.slug}`" class="product-image-container">
                                        <img
                                            loading="lazy"
                                            class="image-wrapper"
                                            :src="product.image || product.product_image"
                                            :data-src="product.image || product.product_image"
                                            class="card-img-top lzy_img"
                                            onload="window.updateHeight ? window.updateHeight() : ''"
                                            :onerror="`this.src='${$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />    
                                        

                                        <product-quick-view-btn :quick-view-details="product" v-if="!isMobile()"></product-quick-view-btn>
                                    </a>
                                    <div v-for="productlab in productLabs">
                                            <div v-if="`${productlab.product_url_key}` == `${product.slug}`" >
                                                <div :class="productlab.position" class="product-label-image" :title="`${productlab.title}`">
                                                    <img :src="`${addImage}/${productlab.image}`" class="product-label"/>
                                                </div>                  
                                            </div>
                                    </div>
                                

                                <div class="card-body">
                                    <div class="product-name col-12 n0-padding">
                                        <a :title="product.name" :href="`${baseUrl}/${product.slug}`" class="unset">
                                        <span class="fs16" v-text="product.name"></span>
                                        </a>
                                    </div>
                                    <div class="sticker new">
                                        <span class="fs16" v-text="product.new"></span>
                                    </div>   

                                    <div class="product-price fs16" v-html="product.priceHTML"></div>

                                    <div
                                        class="product-rating col-12 no-padding"
                                        v-if="product.totalReviews && product.totalReviews > 0">

                                        <star-ratings :ratings="product.avgRating"></star-ratings>
                                            <a class="fs14 align-top unset active-hover" :href="`${$root.baseUrl}/reviews/${product.slug}`">
                                                
                                            </a>
                                    </div>
                                    <div class="product-rating col-12 no-padding" v-else>
                                        <span class="fs14" v-text="product.firstReviewText"></span>
                                    </div>
                                        
                                        

                                        <vnode-injector :nodes="getDynamicHTML(product.addToCartHtml)"></vnode-injector>
                                    
                                </div>
                            </div>
                            
                        </slide>
                        
                    </carousel-component>
                </template>

                <span v-else-if="isProductListLoaded">{{ __('customer::app.wishlist.empty') }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.guest-customer.view.after') !!}
        </section>
    </script>

    <script>
        Vue.component('wishlist-product', {
            template: '#wishlist-product-template',

            data: function () {
                return {
                    'products': [],
                    'isProductListLoaded': false,
                    'addImage' : [],
                }
            },

            watch: {
                '$root.headerItemsCount': function () {
                    this.getProducts();
                }
            },

            mounted: function () {
                this.getProducts();
                this.productLabs = @json($productLabels);
                    this.addImage = @json(asset("storage/"));
            },

            methods: {
                'getProducts': function () {
                    let items = this.getStorageValue('wishlist_product');
                    items = items ? items.join('&') : '';

                    if (items != "") {
                        this.$http
                        .get(`${this.$root.baseUrl}/detailed-products`, {
                            params: { moveToCart: true, items }
                        })
                        .then(response => {
                            this.isProductListLoaded = true;
                            this.products = response.data.products;
                        })
                        .catch(error => {
                            this.isProductListLoaded = true;
                            console.log(this.__('error.something_went_wrong'));
                        });
                    } else {
                        this.products = [];
                        this.isProductListLoaded = true;
                    }
                },

                'removeProduct': function (productId) {
                    let existingItems = this.getStorageValue('wishlist_product');

                    if (productId == "all") {
                        updatedItems = [];
                        this.$set(this, 'products', []);
                    } else {
                        updatedItems = existingItems.filter(item => item != productId);
                        this.$set(this, 'products', this.products.filter(product => product.slug != productId));
                    }

                    this.$root.headerItemsCount++;
                    this.setStorageValue('wishlist_product', updatedItems);

                    window.showAlert(`alert-success`, this.__('shop.general.alert.success'), `${this.__('customer.wishlist.remove-all-success')}`);
                }
            }
        });
    </script>
@endpush