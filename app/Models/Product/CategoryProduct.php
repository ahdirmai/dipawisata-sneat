<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CategoryProduct extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'product_category_products';

    protected $fillable = [
        'name'
    ];
}
