<?php

namespace App\Livewire\Admin\Blog\Category;

use App\Models\Blog\Category;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryForm extends Component
{

    public $method = 'create';

    public $category = null;
    public $name;

    public function render()
    {
        return view('livewire.admin.blog.category.category-form');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Category::create([
                'name' => $this->name,
                'slug' => \Str::slug($this->name),
            ]);

            DB::commit();
            $this->reset();

            $this->dispatch('category-created');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }

    public function update($id)
    {
        $this->validate([
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $category = Category::find($id);
            $category->update([
                'name' => $this->name,
                'slug' => \Str::slug($this->name),
            ]);

            DB::commit();

            $this->reset();
            Alert::success('Success', 'Category updated successfully');
            $this->dispatch('category-updated');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }

    #[On('edit-category')]
    public function editCategoryForm($category)
    {
        $this->category = $category;
        $this->method = 'update';
        $this->name = $category['name'];
    }
}
