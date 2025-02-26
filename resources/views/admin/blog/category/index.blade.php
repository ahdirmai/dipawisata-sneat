<x-admin.app-layout>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Blog /</span> Kategori</h4>

        <div class="card mb-3">

            @livewire('admin.blog.category.category-form')
        </div>


        <div class="card">
            <h5 class="card-header">Data Kategori</h5>
            <div class="table-responsive text-nowrap">
                @livewire('admin.blog.category.category-table', ['categories' => $categories])
            </div>
        </div>
    </div>

    @push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
        Livewire.on('category-created', (event) => {
        // swal alert
        Swal.fire({

        title: 'Success!',
        text: 'Category has been created!',
        icon: 'success',
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1500

        });

        });
        });

        document.addEventListener('livewire:init', () => {
        Livewire.on('category-updated', (event) => {
        // swal alert
        Swal.fire({

        title: 'Success!',
        text: 'Category has been Updated!',
        icon: 'success',
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1500
        });

        });
        });

        document.addEventListener('livewire:init', () => {
        Livewire.on('category-deleted', (event) => {
        // swal alert
        Swal.fire({

        title: 'Success!',
        text: 'Category has been Deleted!',
        icon: 'success',
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1500
        });

        });
        });
    </script>

    @endpush

</x-admin.app-layout>