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
                            <h3 class="card-title mb-2">999</h3>
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
                            <h3 class="card-title mb-2">$12,628</h3>

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
                            <h3 class="card-title mb-2">$12,628</h3>

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
                            <h3 class="card-title mb-2">$12,628</h3>

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
                                src="{{ asset('assets/img/elements/12.jpg') }}" alt="Card image"
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
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="publishToggle" {{
                                            $post->status == 'published' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="publishToggle">Publish</label>
                                    </div>
                                </div>
                                {{-- edit button on end --}}
                                <div class="text-end mt-3">
                                    <a href="" class="btn btn-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse


            </div>


        </div>
    </div>



</x-admin.app-layout>