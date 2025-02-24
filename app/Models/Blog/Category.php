<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'slug'];
    protected $table = 'blog_categories';

    // public function posts()
    // {
    //     return $this->hasMany(Post::class);
    // }
}
