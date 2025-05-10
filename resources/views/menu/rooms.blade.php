@extends('layouts.vertical', ['title' => 'Rooms'])

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
                <li class="breadcrumb-item active">Rooms</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Room List</h5>
                        <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#room-modal">
                            <i class="fas fa-plus me-1"></i> Add Room
                        </button>
                    </div>

                    <div class="modal fade" id="room-modal" tabindex="-1" aria-labelledby="room-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="room-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="room-modalLabel">Add Room</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="option_category_id" class="form-label">Category<span class="text-danger"> *</span></label>
                                                <select class="form-select" id="option_category_id" name="option_category_id" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->option_category_id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="room_number" class="form-label">Room Number<span class="text-danger"> *</span></label>
                                                <input type="text" class="form-control" id="room_number" name="room_number" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="room_type" class="form-label">Room Type<span class="text-danger"> *</span></label>
                                                <input type="text" class="form-control" id="room_type" name="room_type" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="rate_per_night" class="form-label">Rate Per Night<span class="text-danger"> *</span></label>
                                                <input type="number" step="0.01" class="form-control" id="rate_per_night" name="rate_per_night" required min="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="rate_per_pax" class="form-label">Rate Per Pax<span class="text-danger"> *</span></label>
                                                <input type="number" step="0.01" class="form-control" id="rate_per_pax" name="rate_per_pax" required min="0">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="pax" class="form-label">Capacity<span class="text-danger"> *</span></label>
                                                <input type="number" class="form-control" id="pax" name="pax" required min="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">Status<span class="text-danger"> *</span></label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option value="available">Available</option>
                                                    <option value="maintenance">Maintenance</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="check_in_timepickr" class="form-label">Check-in Time</label>
                                                <input id="check_in_timepickr" type="time" class="form-control" name="checked_in">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="check_out_timepickr" class="form-label">Check-out Time</label>
                                                <input id="check_out_timepickr" type="time" class="form-control" name="checked_out">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="images" class="form-label">Room Images</label>
                                                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                                                <small class="text-muted">Accepted formats: JPG, PNG. Max size: 2MB.</small>
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
                        <table id="rooms" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Room #</th>
                                    <th class="text-center">Room Type</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Capacity</th>
                                    <th class="text-center">Rate Per Night</th>
                                    <th class="text-center">Rate Per Pax</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td class="align-middle text-center">{{ $room->room_number }}</td>
                                        <td class="align-middle">{{ Str::title($room->room_type) }}</td>
                                        <td class="align-middle">{{ Str::limit($room->category->name, 15) }}</td>
                                        <td class="align-middle text-center">{{ $room->pax }}</td>
                                        <td class="align-middle text-center">₱{{ number_format($room->rate_per_night, 2) }}</td>
                                        <td class="align-middle text-center">₱{{ number_format($room->rate_per_pax, 2) }}</td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $room->status === 'available' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ Str::ucfirst($room->status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $room->created_at ? \Carbon\Carbon::parse($room->created_at)->format('M. j, Y') : '-' }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('room.availability', $room->room_id) }}" class="btn btn-sm bg-primary-subtle me-1 edit-room-btn" title="Availability">
                                                    <span class="mdi mdi-calendar-blank-outline fs-14 text-primary"></span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-subtle me-1 edit-room-btn" data-bs-toggle="modal" title="View Gallery" data-bs-target="#room-gallery-modal-{{ $room->room_id }}">
                                                    <span class="mdi mdi-image-outline fs-14 text-primary"></span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-subtle me-1 edit-room-btn" 
                                                   data-bs-toggle="modal" 
                                                   title="Update" 
                                                   data-bs-target="#room-modal" 
                                                   data-room='@json($room)'>
                                                    <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                </a>
                                                <form action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger-subtle" title="Delete" onclick="return confirm('Are you sure you want to delete this room?')">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="room-gallery-modal-{{ $room->room_id }}" tabindex="-1" aria-labelledby="room-gallery-modalLabel-{{ $room->room_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="room-gallery-modalLabel-{{ $room->room_id }}">Gallery of Room #{{ $room->room_number }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($room->roomGallery->isNotEmpty())
                                                        <div id="carouselRoomGallery{{ $room->room_id }}" class="carousel slide" data-bs-ride="carousel">
                                                            <div class="carousel-indicators">
                                                                @foreach ($room->roomGallery as $index => $image)
                                                                    <button type="button" data-bs-target="#carouselRoomGallery{{ $room->room_id }}" 
                                                                        data-bs-slide-to="{{ $index }}" 
                                                                        class="{{ $index === 0 ? 'active' : '' }}" 
                                                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                                                                @endforeach
                                                            </div>
                                                            <div class="carousel-inner rounded">
                                                                @foreach ($room->roomGallery as $index => $image)
                                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                        <img src="{{ asset('storage/' . $image->image_name) }}" 
                                                                            class="d-block w-100 img-fluid" 
                                                                            alt="Room Image {{ $index + 1 }}"
                                                                            style="max-height: 500px; object-fit: contain;">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRoomGallery{{ $room->room_id }}" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselRoomGallery{{ $room->room_id }}" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-center align-items-center" style="height: 500px;">
                                                            <img src="{{ asset('images/gallery/no-image.png') }}" alt="No Image" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
        const modal = document.getElementById('room-modal');
        const form = document.getElementById('room-form');
        const formMethod = document.getElementById('form-method');

        const modalTitle = document.getElementById('room-modalLabel');
        
        const roomNumberInput = document.getElementById('room_number');
        const roomTypeInput = document.getElementById('room_type');
        const categoryInput = document.getElementById('option_category_id');
        const paxInput = document.getElementById('pax');
        const ratePerNightInput = document.getElementById('rate_per_night');
        const ratePerPaxInput = document.getElementById('rate_per_pax');
        const checkedInInput = document.getElementById('check_in_timepickr');
        const checkedOutInput = document.getElementById('check_out_timepickr');
        const statusInput = document.getElementById('status');
        const descriptionInput = document.getElementById('description');

        document.querySelectorAll('.edit-room-btn').forEach(button => {
            button.addEventListener('click', () => {
                const room = JSON.parse(button.getAttribute('data-room'));

                modalTitle.textContent = 'Edit Room';
                form.action = "{{ route('rooms.update', '') }}/" + room.room_id;
                formMethod.value = 'PUT';

                roomNumberInput.value = room.room_number || '';
                roomTypeInput.value = room.room_type || '';
                categoryInput.value = room.option_category_id || '';
                paxInput.value = room.pax || '';
                ratePerNightInput.value = room.rate_per_night || '';
                ratePerPaxInput.value = room.rate_per_pax || '';
                checkedInInput.value = room.checked_in ? room.checked_in.slice(0, 5) : '';
                checkedOutInput.value = room.checked_out ? room.checked_out.slice(0, 5) : '';
                statusInput.value = room.status || '';
                descriptionInput.value = room.description || '';
            });
        });

        modal.addEventListener('hidden.bs.modal', () => {
            form.action = "{{ route('rooms.store') }}";
            formMethod.value = 'POST';
            form.reset();
            modalTitle.textContent = 'Add Room';
        });
    </script>
@endsection