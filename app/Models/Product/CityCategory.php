<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CityCategory extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'product_city_categories';
}
