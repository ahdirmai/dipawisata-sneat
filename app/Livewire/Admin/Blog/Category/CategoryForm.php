<?php

namespace App\Livewire\Admin\Blog\Category;

use App\Models\Blog\Category;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryForm extends Component
{

    public $method = 'create';

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
}
