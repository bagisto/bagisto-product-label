# Introduction

Using  this add-on  The store owners can create customized labels/stickers for their product listings. Product labels are a great way to attract visitors' attention toward the products and convert them into customers. It can be used for showing badges for Featured Items, Popular, New, Out of Stock, Deals, and much more.

It packs in lots of demanding features that allows your business to scale in no time:

- Promotional Stickers
** Add custom labels to attract massive attention of the visitors.

- Design Labels
** Configure custom label title, logo, status, and position.
 
- Label Position
** Define the display location of the label on the product.

- Display Labels
** Visible on all pages - product, category, search, advanced search, wishlist, compare, and other CMS pages.

- Assign Labels
** Assign labels to all the product types.

- Create Unique Labels
** Create & Manage custom labels for sale, out of stock, new arrival, exclusive products, etc


## Requirements

- **Bagisto**: 1.3.2

## Installation :
- Run the following command
```
composer require bagisto/bagisto-product-label
```

- Goto config/concord.php file and add following line under 'modules'
```php
\Webkul\ProductLabelSystem\Providers\ModuleServiceProvider::class
```

- Run these commands below to complete the setup
```
composer dump-autoload
```

```
php artisan migrate
php artisan route:cache
php artisan config:cache
```
```
php artisan vendor:publish --force
```

-> Press the number before ProductLabelSystemServiceProvider and then press enter to publish all assets and configurations.

- Goto config/app.php file and set your 'default_country'.


> That's it, now just execute the project on your specified domain.
