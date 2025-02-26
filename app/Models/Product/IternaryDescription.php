<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class IternaryDescription extends Model
{

    protected $table = 'product_iternary_descriptions';

    protected $fillable = [
        'title',
        'description',
        'journey_iternary',
        'category',
        'duration'
    ];
}
