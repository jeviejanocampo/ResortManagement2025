@extends('layouts.vertical', ['title' => 'Categories'])

@section('css')
    @vite([
        'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
        'node_modules/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css',
        'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
        'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'
    ])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Category List</h5>
                        <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#option-category-modal">
                            <i class="fas fa-plus me-1"></i> Add Category
                        </button>
                    </div>

                    <div class="modal fade" id="option-category-modal" tabindex="-1" aria-labelledby="option-category-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <form id="option-category-form" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="option-category-modalLabel">Add Category</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name<span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status<span class="text-danger"> *</span></label>
                                            <select class="form-select" id="status" name="status">
                                                <option selected disabled value="">Choose...</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="option-categories" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                    @if (auth()->user() && auth()->user()->is_superuser)
                                        <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)    
                                    <tr>
                                        <td class="align-middle">
                                            {{ $category->name }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $category->status === 'active' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ Str::ucfirst($category->status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $category->created_at ? \Carbon\Carbon::parse($category->created_at)->format('M. j, Y') : '-' }}
                                        </td>
                                        @if (auth()->user() && auth()->user()->is_superuser)
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="javascript:void(0);" class="btn btn-sm bg-primary-subtle me-1 edit-option-category-btn" data-bs-toggle="modal" title="Update" data-bs-target="#option-category-modal" data-option-category='@json($category)'>
                                                        <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                    </a>
                                                    <form action="{{ route('categories.destroy', $category->option_category_id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" aria-label="anchor" class="btn btn-sm bg-danger-subtle" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                        </button>
                                                    </form>                                                    
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/datatable.init.js'])

    <script>
        const modal = document.getElementById('option-category-modal');
        const form = document.getElementById('option-category-form');
        const formMethod = document.getElementById('form-method');

        const modalTitle = document.getElementById('option-category-modalLabel');
        
        const nameInput = document.getElementById('name');
        const statusInput = document.getElementById('status');

        document.querySelectorAll('.edit-option-category-btn').forEach(button => {
            button.addEventListener('click', () => {
                const category = JSON.parse(button.getAttribute('data-option-category'));

                modalTitle.textContent = 'Edit Category';

                form.action = "{{ url('categories') }}/" + category.option_category_id;
                formMethod.value = 'PUT';

                nameInput.value = category.name || '';
                statusInput.value = category.status || '';
            });
        });

        modal.addEventListener('hidden.bs.modal', () => {
            form.action = "{{ route('categories.store') }}";
            formMethod.value = 'POST';
            form.reset();

            modalTitle.textContent = 'Add Category';
        });
    </script>
@endsection
