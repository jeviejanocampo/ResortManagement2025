@extends('layouts.vertical', ['title' => 'Users'])

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
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">User List</h5>
                        <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#user-modal">
                            <i class="fas fa-plus me-1"></i> Add User
                        </button>
                    </div>

                    <div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="user-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="user-form" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="user-modalLabel">Add User</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="firstname" class="form-label">First name<span class="text-danger"> *</span></label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lastname" class="form-label">Last name<span class="text-danger"> *</span></label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="text" class="form-control" id="user-dob-datepicker" name="date_of_birth">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select class="form-select" id="gender" name="gender">
                                                    <option selected disabled value="">Choose...</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                    <option value="prefer_not_to_say">Prefer not to say</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="phone_number" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email<span class="text-danger"> *</span></label>
                                                <input type="text" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            @if (auth()->user() && auth()->user()->is_superuser)
                                                <div class="col-md-4">
                                                    <input type="checkbox" class="form-check-input" id="superuser" name="is_superuser">
                                                    <label class="form-check-label" for="superuser">Superuser</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="checkbox" class="form-check-input" id="owner" name="is_owner">
                                                    <label class="form-check-label" for="owner">Owner</label>
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <input type="checkbox" class="form-check-input" id="Staff" name="is_staff">
                                                <label class="form-check-label" for="Staff">Staff</label>
                                            </div>
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
                        <table id="users" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">DOB</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Superuser</th>
                                    <th class="text-center">Owner</th>
                                    <th class="text-center">Staff</th>
                                    <th class="text-center">Verified</th>
                                    <th class="text-center">Created At</th>
                                    @if (auth()->user() && auth()->user()->is_superuser)
                                        <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex justify-content-center align-items-center bg-primary-subtle text-primary rounded-circle me-2 fw-semibold" style="width: 40px; height: 40px; font-size: 1rem;">
                                                    {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->lastname, 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold">{{ Str::title($user->firstname . ' ' . $user->lastname) }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('M. j, Y') : '-' }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $user->gender ? ($user->gender === 'prefer_not_to_say' ? 'Prefer not to say' : Str::title($user->gender)) : '-' }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $user->phone_number ?? '-' }}
                                        </td>
                                        <td class="align-middle">{{ $user->email }}</td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $user->is_superuser ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $user->is_superuser ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $user->is_owner ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $user->is_owner ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $user->is_staff ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $user->is_staff ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                      
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $user->email_verified_at ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $user->email_verified_at ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M. j, Y') : '-' }}
                                        </td>
                                        @if (auth()->user() && auth()->user()->is_superuser)
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="javascript:void(0);" class="btn btn-sm bg-primary-subtle me-1 edit-user-btn" data-bs-toggle="modal" data-bs-target="#user-modal" data-user='@json($user)'>
                                                        <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                    </a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" data-bs-original-title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
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
    @vite([
        'resources/js/pages/datatable.init.js',
        'resources/js/pages/form-picker.js'
    ])

    <script>
        const modal = document.getElementById('user-modal');
        const form = document.getElementById('user-form');
        const formMethod = document.getElementById('form-method');

        const modalTitle = document.getElementById('user-modalLabel');
        
        const firstnameInput = document.getElementById('firstname');
        const lastnameInput = document.getElementById('lastname');
        const dobInput = document.getElementById('basic-datepicker');
        const genderInput = document.getElementById('gender');
        const phoneInput = document.getElementById('phone_number');
        const emailInput = document.getElementById('email');

        const isSuperuserInput = document.getElementById('superuser');
        const isOwnerInput = document.getElementById('owner');
        const isStaffInput = document.getElementById('Staff');

        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', () => {
                const user = JSON.parse(button.getAttribute('data-user'));

                modalTitle.textContent = 'Edit User';

                form.action = "{{ url('users') }}/" + user.id;
                formMethod.value = 'PUT';

                firstnameInput.value = user.firstname || '';
                lastnameInput.value = user.lastname || '';
                dobInput.value = user.date_of_birth ? new Date(user.date_of_birth).toISOString().split('T')[0] : '';
                genderInput.value = user.gender || '';
                phoneInput.value = user.phone_number || '';
                emailInput.value = user.email || '';

                if (isSuperuserInput) isSuperuserInput.checked = !!user.is_superuser;
                if (isOwnerInput) isOwnerInput.checked = !!user.is_owner;

                isStaffInput.checked = !!user.is_staff;
            });
        });

        modal.addEventListener('hidden.bs.modal', () => {
            form.action = "{{ route('users.store') }}";
            formMethod.value = 'POST';
            form.reset();

            modalTitle.textContent = 'Add User';
        });
    </script>
@endsection
