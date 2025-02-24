<x-admin.app-layout>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Blog /</span> Kategori</h4>

        <div class="card mb-3">
            
            @livewire('admin.blog.category.category-form')
        </div>


        <div class="card">
            <h5 class="card-header">Categories Data</h5>
            <div class="table-responsive text-nowrap">
                @livewire('admin.blog.category.category-table', ['categories' => $categories])
            </div>
        </div>
    </div>

</x-admin.app-layout>
