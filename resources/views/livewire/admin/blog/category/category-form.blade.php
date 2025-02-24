<div>
    <h5 class="card-header">{{ $method == 'create' ? "Create" : 'Update' }} Kategori</h5>
    <div class="row">
        <div class="col-xl">
            <div class="card-body">
                @if($method == 'create')
                <form wire:submit="save">
                    @else
                    <form wire:submit='update({{ $category["id"] }})'>
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama Kategori</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                placeholder="Masukan Nama Kategori" wire:model="name" />
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ $method ==
                                'create' ?
                                "Create" : 'Update'
                                }}</button>

                        </div>
                    </form>
            </div>
        </div>

    </div>

</div>