<x-admin.app-layout>

    @push('after-styles')
    <script src="https://cdn.tiny.cloud/1/rr2c6yz7kf287oymazs5jife4zf1q6uobl3rosa5uxzllfre/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @endpush

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Blog /</span> <a
                href="{{ route('admin.blog.post.index') }}">Post</a> / Edit</h4>

        <div class="text-start mb-3">
            <a href="{{ route('admin.blog.post.index') }}" class="btn btn-primary">
                <i class="menu-icon tf-icons bx bx-arrow-back"></i>
            </a>
        </div>

        {{-- form --}}
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Postingan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.blog.post.update', $post->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PATCH')
                            {{-- Thumbnail --}}
                            <div class="mb-3">
                                <label class="form-label" for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                    id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(event)" />
                                <img id="thumbnail-preview" src="{{ $post->getFirstMediaUrl('thumbnails') }}"
                                    alt="Thumbnail Preview"
                                    style="display: {{ $post->getFirstMediaUrl('thumbnails') ? 'block' : 'none' }}; margin-top: 10px; max-height: 200px;">
                                @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <script>
                                function previewImage(event) {
                                    var reader = new FileReader();
                                    reader.onload = function(){
                                        var output = document.getElementById('thumbnail-preview');
                                        output.src = reader.result;
                                        output.style.display = 'block';
                                    };
                                    reader.readAsDataURL(event.target.files[0]);
                                }
                            </script>

                            {{-- category --}}
                            <div class="mb-3">
                                <label class="form-label" for="category">Kategori</label>
                                {{-- categories --}}
                                <select class="form-select  @error('category') is-invalid @enderror" id="category"
                                    name="category">
                                    <option selected>Pilih Kategori</option>
                                    @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ $post->category_id == $item->id ? 'selected' : ''
                                        }}>
                                        {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="title">Judul</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" placeholder="Masukan Judul Berita"
                                    value="{{ old('title', $post->title) }}" />
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- content using --}}
                            <div class="mb-3">
                                <label class="form-label" for="content">Content</label>
                                <textarea id="tiny" name="content"
                                    class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea#tiny'
        });
    </script>
    @endpush
</x-admin.app-layout>