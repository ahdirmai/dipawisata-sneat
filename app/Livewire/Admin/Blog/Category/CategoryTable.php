<?php

namespace App\Livewire\Admin\Blog\Category;

use App\Models\Blog\Category;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryTable extends Component
{

    public $categories;


    public function mount($categories)
    {
        $this->categories = $categories;
    }

    public function render()
    {
        return view('livewire.admin.blog.category.category-table');
    }

    #[On('category-created')]
    public function updateCategoryList()
    {
        // refresh the list of categories
        $this->categories = Category::all()->sortByDesc('created_at');
    }
}
