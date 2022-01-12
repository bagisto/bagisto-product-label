@php
    $count = $velocityMetaData ? $velocityMetaData->featured_product_count : 10;
    $direction = core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr';
    $productLabels = (app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getAllProductsLabel());
@endphp


<featured-products></featured-products>

@push('scripts')
    <script type="text/x-template" id="featured-products-template">
        <div class="container-fluid featured-products">
            <shimmer-component v-if="isLoading && !isMobileView"></shimmer-component>

            <template v-else-if="featuredProducts.length > 0">
                <card-list-header heading="{{ __('shop::app.home.featured-products') }}">
                </card-list-header>
                
                <div class="carousel-products vc-full-screen {{ $direction }}" v-if="!isMobileView">
                    <carousel-component
                        slides-per-page="6"
                        navigation-enabled="hide"
                        pagination-enabled="hide"
                        id="fearured-products-carousel"
                        locale-direction="{{ $direction }}"
                        :autoplay="false"
                        :slides-count="featuredProducts.length">

                        <slide
                            :key="index"
                            :slot="`slide-${index}`"
                            v-for="(product, index) in featuredProducts">
                            
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
                                    
                                    <div v-for="productlab in productLabs">
                                        <div v-if="`${productlab.product_url_key}` == `${product.slug}`" >
                                            <div :class="productlab.position" class="product-label-image" :title="`${productlab.title}`">
                                                <img :src="`${addImage}/${productlab.image}`" class="product-label"/>
                                            </div>                  
                                        </div>
                                    </div>
                                    </a>

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
                </div>

                <div class="carousel-products vc-small-screen {{ $direction }}" v-else>
                    <carousel-component
                        slides-per-page="2"
                        navigation-enabled="hide"
                        pagination-enabled="hide"
                        id="fearured-products-carousel"
                        locale-direction="{{ $direction }}"
                        :slides-count="featuredProducts.length">

                        <slide
                            :key="index"
                            :slot="`slide-${index}`"
                            v-for="(product, index) in featuredProducts">
                            
                            <div class="card grid-card product-card-new">
                                <a :href="`${baseUrl}/${product.slug}`" :title="product.name" class="product-image-container">
                                    <img
                                        loading="lazy"
                                        :alt="product.name"
                                        :src="product.image || product.product_image"
                                        :data-src="product.image || product.product_image"
                                        class="card-img-top lzy_img"
                                        :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />

                                    <product-quick-view-btn :quick-view-details="product"></product-quick-view-btn>
                               
                                <div v-for="productlab in productLabs">
                                            
                                    <div v-if="`${productlab.product_url_key}` == `${product.slug}`" >
                                        <div :class="productlab.position" class="product-label-image" :title="`${productlab.title}`">
                                            <img :src="`${addImage}/${productlab.image}`" class="product-label"/>
                                        </div>                  
                                    </div>
                                </div>
                                </a>
                                <div class="card-body">
                                    <div class="product-name col-12 n0-padding">
                                        <a :title="product.name" :href="`${baseUrl}/${product.slug}`" class="unset">
                                            <span class="fs16" v-text="product.name"></span>
                                        </a>
                                    </div>
                                    <div class="sticker new" v-if="product.new">
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
                </div>
            </template>

        </div>
    </script>

    <script type="text/javascript">
        (() => {
            Vue.component('featured-products', {
                'template': '#featured-products-template',
                data: function () {
                    return {
                        'list': false,
                        'isLoading': true,
                        'featuredProducts': [],
                        'isMobileView': this.$root.isMobile(),
                        'addImage' : [],

                    }
                },

                mounted: function () {
                    this.getFeaturedProducts();
                    this.productLabs = @json($productLabels);
                    this.addImage = @json(asset("storage/"));
                },

                methods: {
                    'getFeaturedProducts': function () {
                        this.$http.get(`${this.baseUrl}/category-details?category-slug=featured-products&count={{ $count }}`)
                        .then(response => {
                            var count = '{{$count}}';
                            if (response.data.status && count != 0 )
                            {
                                this.featuredProducts = response.data.products;
                            }else{
                                this.featuredProducts = 0;   
                            }

                            this.isLoading = false;
                        })
                        .catch(error => {
                            this.isLoading = false;
                            console.log(this.__('error.something_went_wrong'));
                        })
                    }
                }
            })
        })()
    </script>
@endpush
