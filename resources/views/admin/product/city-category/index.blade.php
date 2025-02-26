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
        <div class="card">
            <div class="card-body">
                <form id="city-category-form" action="{{ route('admin.product.city-categories.store') }}" method="POST"
                    enctype="multipart/form-data">
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
                        <script>
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
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cityCategories as $cityCategory)
                        <tr>
                            <td>{{ $cityCategory->name }}</td>
                            <td><img src="{{ $cityCategory->getFirstMediaUrl('icon') }}" alt="{{ $cityCategory->name }}"
                                    width="50"></td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="editCityCategory({{ $cityCategory->id }}, '{{ $cityCategory->name }}', '{{ $cityCategory->getFirstMediaUrl('icon') }}')">Edit</button>
                                <form action="{{ route('admin.product.city-categories.destroy', $cityCategory->id) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('after-scripts')
    <script>
        function editCityCategory(id, name, iconUrl) {
            const form = document.getElementById('city-category-form');
            form.action = `/admin/product/city-categories/update/${id}`;
            document.getElementById('form-method').value = 'PATCH';
            document.getElementById('name').value = name;

            const iconPreview = document.getElementById('icon-preview');
            iconPreview.src = iconUrl;
            iconPreview.style.display = 'block';
        }
    </script>
    @endpush

</x-admin.app-layout>