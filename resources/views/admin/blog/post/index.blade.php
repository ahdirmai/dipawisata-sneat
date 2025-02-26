<x-admin.app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Blog /</span> Post</h4>


        {{-- alert using session --}}
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

        {{-- card --}}

        <div class="col-lg-12 col-md-12 order-1">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Views</span>
                            <h3 class="card-title mb-2">{{ $views }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Post</span>
                            <h3 class="card-title mb-2">{{ $total_post }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span class="fw-semibold d-block mb-1">Published</span>
                            <h3 class="card-title mb-2">{{ $published }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Draft</span>
                            <h3 class="card-title mb-2">{{ $drafts }}</h3>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-end mb-4">
            <a href="{{ route('admin.blog.post.create') }}" class="btn btn-primary">Create Post</a>
        </div>
        {{-- button create post --}}
        <div class="row mb-2">
            <div class="col-md-12">
                @forelse($posts as $post)
                <div class="card mb-3 p-2">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img class="card-img card-img-left img-fluid"
                                src="{{ $post->getFirstMediaUrl('thumbnails', 'thumbnail') }}" alt="Card image"
                                style="width: 100%; height: auto;" />
                        </div>
                        <div class="col-md-9">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title">{{ ucfirst($post->title) }}</h5>
                                        {{-- muted text category --}}
                                        <span class="text-muted
                                            fw-semibold">{{ ucfirst($post->category->name) }}</span>

                                    </div>
                                    <p class="card-text">
                                        {{ Str::limit(strip_tags($post->content), 100) }}

                                    </p>
                                    <p class="card-text"><small class="text-muted">{{ $post->updated_at->diffForHumans()
                                            }}</small>
                                    </p>
                                    {{-- views and likes --}}
                                    <div class="d-flex justify-content-start mb-2">
                                        <div class="me-3">
                                            <i class="bx bx-show"></i> {{ $post->views }}
                                        </div>
                                        <div>
                                            <i class="bx bx-like"></i> {{ $post->likes }}
                                        </div>
                                    </div>
                                    {{-- publish toggle --}}
                                    <form action="{{ route('admin.blog.post.togglePublish', $post) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                id="publishToggle{{ $post->id }}" {{ $post->status == 'published' ?
                                            'checked' : '' }}
                                            onchange="this.form.submit()">
                                            <label class="form-check-label"
                                                for="publishToggle{{ $post->id }}">Publish</label>
                                        </div>
                                    </form>
                                </div>
                                {{-- edit button on end --}}
                                <div class="text-end mt-3">
                                    <a href="{{ route('admin.blog.post.edit',$post) }}" class="btn btn-primary">Edit</a>
                                    {{-- delete button --}}
                                    <form action="{{ route('admin.blog.post.destroy',$post) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info text-center">
                    No post found
                </div>
                @endforelse


            </div>


        </div>
    </div>



</x-admin.app-layout>