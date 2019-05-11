<?php

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$records = [
    		[
    			"name" => "Product Pertama",
    			"price" => "5000",
    		],
    		[
    			"name" => "Product Kedua",
    			"price" => "3500",
    		],
    	];

    	$product = new Product;
    	foreach ($records as $record) {
    		$random = strtoupper(str_random(5));
    		$record["sku"] = "SKU-{$random}";
    		$product->create($record);
    	}
    }
}
