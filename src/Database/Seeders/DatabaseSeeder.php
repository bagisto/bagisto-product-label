<?php

namespace Webkul\ProductLabelSystem\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(ProductLabelImageSeeder::class);
    }
}