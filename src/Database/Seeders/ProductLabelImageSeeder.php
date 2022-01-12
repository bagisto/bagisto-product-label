<?php

namespace Webkul\ProductLabelSystem\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductLabelImageSeeder extends Seeder
{
    
    static $product_labels =['None'];

    // DB::table('category_translations')->delete();

    // $now = Carbon::now();

    
    public function run()
    {
    
        foreach (self::$product_labels as $product_label) {
            DB::table('product_labels')->insert([
                'position' => $product_label,
                'status' => 0,
                'image' => null,
            ]);
        }
    }
}