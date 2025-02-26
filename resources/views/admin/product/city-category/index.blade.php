<x-admin.app-layout>
    @push('after-styles')
    <script src="https://cdn.tiny.cloud/1/rr2c6yz7kf287oymazs5jife4zf1q6uobl3rosa5uxzllfre/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">City Categories</h4>
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

        <button class="btn btn-primary mb-4" id="createCityCategoryBtn">Create City Category</button>

        @foreach($cityCategories as $cityCategory)
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ $cityCategory->getFirstMediaUrl('icon') }}" alt="{{ $cityCategory->name }}"
                        class="rounded-circle" width="50" height="50">
                    <div class="ms-3 flex-grow-1">
                        <h5 class="mb-0">{{ $cityCategory->name }}</h5>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-warning me-2 editCityCategoryBtn"
                            data-id="{{ $cityCategory->id }}" data-name="{{ $cityCategory->name }}"
                            data-icon="{{ $cityCategory->getFirstMediaUrl('icon') }}">
                            <i class="tf-icons bx bx-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteCityCategoryBtn" data-id="{{ $cityCategory->id }}">
                            <i class="tf-icons bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="cityCategoryModal" tabindex="-1" aria-labelledby="cityCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cityCategoryModalLabel">Create City Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="city-category-form" action="{{ route('admin.product.city-categories.store') }}"
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
                    Are you sure you want to delete this city category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete-form" action="" method="POST" style="display:inline-block;">
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
        document.getElementById('createCityCategoryBtn').addEventListener('click', function() {
            const form = document.getElementById('city-category-form');
            form.action = '{{ route('admin.product.city-categories.store') }}';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('name').value = '';
            document.getElementById('icon').value = '';
            document.getElementById('icon-preview').style.display = 'none';
            document.getElementById('cityCategoryModalLabel').innerText = 'Create City Category';
            const modal = new bootstrap.Modal(document.getElementById('cityCategoryModal'));
            modal.show();
        });

        document.querySelectorAll('.editCityCategoryBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const iconUrl = this.getAttribute('data-icon');

                const form = document.getElementById('city-category-form');
                form.action = `/admin/product/city-categories/update/${id}`;
                document.getElementById('form-method').value = 'PATCH';
                document.getElementById('name').value = name;

                const iconPreview = document.getElementById('icon-preview');
                iconPreview.src = iconUrl;
                iconPreview.style.display = 'block';

                document.getElementById('cityCategoryModalLabel').innerText = 'Edit City Category';
                const modal = new bootstrap.Modal(document.getElementById('cityCategoryModal'));
                modal.show();
            });
        });

        document.querySelectorAll('.deleteCityCategoryBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const deleteForm = document.getElementById('delete-form');
                deleteForm.action = `/admin/product/city-categories/destroy/${id}`;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('icon-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @endpush

</x-admin.app-layout>