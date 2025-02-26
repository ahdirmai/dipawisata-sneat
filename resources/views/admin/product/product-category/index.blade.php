<x-admin.app-layout>
    @push('after-styles')
    <script src="https://cdn.tiny.cloud/1/rr2c6yz7kf287oymazs5jife4zf1q6uobl3rosa5uxzllfre/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Product Categories</h4>
        {{-- session success --}}

        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
        @endif

        {{-- error session --}}
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('error') }}
        </div>
        @endif

        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#productCategoryModal">Add Product
            Category</button>

        @foreach($productCategories as $productCategory)
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ $productCategory->getFirstMediaUrl('icon') }}" alt="{{ $productCategory->name }}"
                        class="rounded-circle" width="50" height="50">
                    <div class="ms-3 flex-grow-1">
                        <h5 class="mb-0">{{ $productCategory->name }}</h5>
                        <small>{{ $productCategory->products_count ?? 0 }} products</small>
                    </div>
                    <div>

                        <form action="{{ route('admin.product.product-categories.togglePublish', $productCategory) }}"
                            method="POST" style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox"
                                    id="flexSwitchCheckChecked{{ $productCategory->id }}" onchange="this.form.submit()"
                                    {{ $productCategory->is_active ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="flexSwitchCheckChecked{{ $productCategory->id }}">Publish</label>
                            </div>
                        </form>

                        <button class="btn btn-sm btn-warning me-2 edit-button" data-id="{{ $productCategory->id }}"
                            data-name="{{ $productCategory->name }}"
                            data-icon="{{ $productCategory->getFirstMediaUrl('icon') }}" data-bs-toggle="modal"
                            data-bs-target="#productCategoryModal">
                            <i class="tf-icons bx bx-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-button" data-id="{{ $productCategory->id }}">
                            <i class="tf-icons bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Product Category Modal -->
    <div class="modal fade" id="productCategoryModal" tabindex="-1" aria-labelledby="productCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productCategoryModalLabel">Add Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="product-category-form" action="{{ route('admin.product.product-categories.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="form-method" name="_method" value="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" id="icon" name="icon"
                                class="form-control @error('icon') is-invalid @enderror" onchange="previewImage(event)">
                            @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="icon-preview" src="#" alt="Icon Preview" style="display:none; margin-top: 10px;"
                                width="100">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete-form" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('after-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productCategoryForm = document.getElementById('product-category-form');
            const productCategoryModal = document.getElementById('productCategoryModal');
            const productCategoryModalLabel = document.getElementById('productCategoryModalLabel');
            const formMethod = document.getElementById('form-method');
            const nameInput = document.getElementById('name');
            const iconInput = document.getElementById('icon');
            const iconPreview = document.getElementById('icon-preview');

            productCategoryModal.addEventListener('hidden.bs.modal', function () {
                productCategoryForm.action = '{{ route('admin.product.product-categories.store') }}';
                formMethod.value = 'POST';
                nameInput.value = '';
                iconInput.value = '';
                iconPreview.style.display = 'none';
                productCategoryModalLabel.textContent = 'Add Product Category';
            });

            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const iconUrl = this.getAttribute('data-icon');

                    productCategoryForm.action = `/admin/product/product-categories/update/${id}`;
                    formMethod.value = 'PATCH';
                    nameInput.value = name;
                    iconPreview.src = iconUrl;
                    iconPreview.style.display = 'block';
                    productCategoryModalLabel.textContent = 'Edit Product Category';
                });
            });

            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const form = document.getElementById('delete-form');
                    form.action = `/admin/product/product-categories/destroy/${id}`;
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });

            window.previewImage = function (event) {
                const reader = new FileReader();
                reader.onload = function () {
                    iconPreview.src = reader.result;
                    iconPreview.style.display = 'block';
                };
                reader.readAsDataURL(event.target.files[0]);
            };
        });
    </script>
    @endpush

</x-admin.app-layout>