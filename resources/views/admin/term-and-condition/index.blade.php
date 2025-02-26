<x-admin.app-layout>
    @push('after-styles')
    <script src="https://cdn.tiny.cloud/1/rr2c6yz7kf287oymazs5jife4zf1q6uobl3rosa5uxzllfre/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Syarat Dan Ketentuan Kredit</h4>

        <div class="card">

            <div class="card-body">

                <form action="{{ route('admin.term-and-condition.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">

                        <textarea id="tiny" name="content"
                            class="form-control @error('content') is-invalid @enderror">{{ $termAndCondition->content?? old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    @push('after-scripts')
    <script>
        tinymce.init({
            selector: 'textarea#tiny'
        });
    </script>
    @endpush

</x-admin.app-layout>