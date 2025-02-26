<x-admin.app-layout>
    @push('after-styles')
    <script src="https://cdn.tiny.cloud/1/rr2c6yz7kf287oymazs5jife4zf1q6uobl3rosa5uxzllfre/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Deskripsi & Iternari</h4>
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

        <button id="create-new-description" class="btn btn-primary mb-4">Create New Description</button>

        @foreach($descriptions as $description)
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="ms-3 flex-grow-1">
                        <h5 class="mb-0">{{ $description->title }}</h5>
                        <p class="mb-0">Category: {{ $description->category }}</p>
                        <p class="mb-0">Duration: {{ $description->duration }} days</p>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-warning me-2 edit-description" data-id="{{ $description->id }}"
                            data-title="{{ $description->title }}" data-description="{{ $description->description }}"
                            data-iternary="{{ $description->journey_iternary }}"
                            data-category="{{ $description->category }}" data-duration="{{ $description->duration }}">
                            <i class="tf-icons bx bx-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-description" data-id="{{ $description->id }}">
                            <i class="tf-icons bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="createEditModal" tabindex="-1" aria-labelledby="createEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEditModalLabel">Create/Edit Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="product-category-form" action="{{ route('admin.product.description-iternary.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="form-method" name="_method" value="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select id="category" name="category"
                                    class="form-control @error('category') is-invalid @enderror">
                                    <option value="Umroh reguler">Umroh reguler</option>
                                    <option value="Umroh plus turki">Umroh plus turki</option>
                                    <option value="Umroh plus mesir">Umroh plus mesir</option>
                                    <option value="Umroh plus dubai">Umroh plus dubai</option>
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="duration" class="form-label">Duration</label>
                                <select id="duration" name="duration"
                                    class="form-control @error('duration') is-invalid @enderror">
                                    @for ($i = 2; $i <= 30; $i++) <option value="{{ $i }}">{{ $i }} days</option>
                                        @endfor
                                </select>
                                @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="journey_iternary" class="form-label">Journey Iternary</label>
                            <textarea id="journey_iternary" name="journey_iternary"
                                class="form-control @error('journey_iternary') is-invalid @enderror">{{ old('journey_iternary') }}</textarea>
                            @error('journey_iternary')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
        document.getElementById('create-new-description').addEventListener('click', openCreateModal);

        document.querySelectorAll('.edit-description').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');
                const iternary = this.getAttribute('data-iternary');
                const category = this.getAttribute('data-category');
                const duration = this.getAttribute('data-duration');
                editdescriptions(id, title, description, iternary, category, duration);
            });
        });

        document.querySelectorAll('.delete-description').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                confirmDelete(id);
            });
        });

        function openCreateModal() {
            const form = document.getElementById('product-category-form');
            form.action = '{{ route('admin.product.description-iternary.store') }}';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('journey_iternary').value = '';
            document.getElementById('category').value = '';
            document.getElementById('duration').value = '';
            const createEditModal = new bootstrap.Modal(document.getElementById('createEditModal'));
            createEditModal.show();
        }

        function editdescriptions(id, name, description, iternary, category, duration) {
            const form = document.getElementById('product-category-form');
            form.action = `/admin/product/description-iternary/update/${id}`;
            document.getElementById('form-method').value = 'PATCH';
            document.getElementById('title').value = name;
            document.getElementById('description').value = description;
            document.getElementById('journey_iternary').value = iternary;
            document.getElementById('category').value = category;
            document.getElementById('duration').value = duration;
            const createEditModal = new bootstrap.Modal(document.getElementById('createEditModal'));
            createEditModal.show();
        }

        function confirmDelete(id) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/product/description-iternary/destroy/${id}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
    @endpush

</x-admin.app-layout>