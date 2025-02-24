<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @forelse($categories as $category)
        <tr>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$loop->iteration}}</strong>
            </td>
            <td>{{ ucfirst($category->name) }}</td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item" wire:click="editCategory({{ $category->id }})"><i
                                class="bx bx-edit-alt me-1"></i>
                            Edit</button>
                        <button class="dropdown-item" wire:click="deleteCategory({{ $category->id }})"
                            wire:confirm="Hapus Kategori ini?"><i class="bx bx-trash me-1"></i>
                            Delete</button>
                    </div>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No data available</td>
        </tr>

        @endforelse

    </tbody>
</table>