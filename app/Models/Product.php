<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

    protected $table = 'products';

    protected $casts = [
    	'price' => 'integer',
    	'is_active' => 'boolean',
    ];

    protected $fillable = [
    	'sku',
    	'name',
    	'stock',
    	'price',
    	'description',
    ];
}
