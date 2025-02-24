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

    #[On(['category-created', 'category-updated'])]
    public function updateCategoryList()
    {
        // refresh the list of categories
        $this->categories = Category::all()->sortByDesc('created_at');
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        $this->dispatch('edit-category', $category);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        try {
            $category->delete();
            $this->updateCategoryList();
            $this->dispatch('category-deleted');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }
}
