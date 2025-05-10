@extends('layouts.vertical', ['title' => 'Venues'])

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
                <li class="breadcrumb-item active">Venues</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Venue List</h5>
                        <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#venue-modal">
                            <i class="fas fa-plus me-1"></i> Add Venue
                        </button>
                    </div>

                    <div class="modal fade" id="venue-modal" tabindex="-1" aria-labelledby="venue-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="venue-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="venue-modalLabel">Add Venue</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="venue_name" class="form-label">Venue Name<span class="text-danger"> *</span></label>
                                                <input type="text" class="form-control" id="venue_name" name="name" required>
                                            </div>
                                            <div class="col-md-6">
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
                                                <label for="check_in_timepickr" class="form-label">Check-in</label>
                                                <input class="form-control" id="check_in_timepickr" name="check_in_time">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="check_out_timepickr" class="form-label">Check-out</label>
                                                <input class="form-control" id="check_out_timepickr" name="check_out_time">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="visitor_limit_timepickr" class="form-label">Visitor Curfew</label>
                                                <input type="time" class="form-control" id="visitor_limit_timepickr" name="visitor_time_limit">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="additional_overnight_price_per_pax" class="form-label">Additional Overnight Price Per Pax</label>
                                                <input type="number" class="form-control" id="additional_overnight_price_per_pax" name="additional_overnight_price_per_pax" step="0.01">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
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
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="tiers-container" class="form-label">Pricing Tiers</label>
                                                <div id="tiers-container"></div>
                                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-tier-btn">
                                                    <i class="mdi mdi-plus"></i> Add Tier
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="images" class="form-label">Venue Images</label>
                                                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                                                <small class="text-muted">Accepted formats: JPG, PNG. Max size: 5MB.</small>
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
                        <table id="venues" class="table table-striped table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Venue Name</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Pricing Tiers</th>
                                    <th class="text-center">Extra Pax Price</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($venues as $venue)
                                    <tr>
                                        <td class="align-middle text-center">{{ $venue->name }}</td>
                                        <td class="align-middle">{{ Str::limit($venue->category->name, 15) }}</td>
                                        <td class="align-middle">
                                            @if($venue->tiers->isNotEmpty())
                                                @foreach($venue->tiers as $tier)
                                                    ₱{{ number_format($tier->price, 2) }} (Max {{ $tier->max_pax }} pax)<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            ₱{{ number_format($venue->additional_overnight_price_per_pax ?? 0, 2) }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $venue->status === 'available' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ ucfirst($venue->status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">{{ $venue->created_at ? \Carbon\Carbon::parse($venue->created_at)->format('M. j, Y') : '-' }}</td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="#" class="btn btn-sm bg-primary-subtle me-1 edit-venue-btn" title="Availability">
                                                    <span class="mdi mdi-calendar-blank-outline fs-14 text-primary"></span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-subtle me-1 edit-venue-btn" data-bs-toggle="modal" title="View Gallery" data-bs-target="#venue-gallery-modal-{{ $venue->venue_id }}">
                                                    <span class="mdi mdi-image-outline fs-14 text-primary"></span>
                                                </a>
                                                <button class="btn btn-sm bg-primary-subtle me-1 edit-venue-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#venue-modal" 
                                                    data-venue='@json($venue)'
                                                    data-tiers='@json($venue->tiers)'>
                                                    <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                </button>
                                                <form action="{{ route('venues.destroy', $venue->venue_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger-subtle" onclick="return confirm('Are you sure?')">
                                                        <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="venue-gallery-modal-{{ $venue->venue_id }}" tabindex="-1" aria-labelledby="venue-gallery-modalLabel-{{ $venue->venue_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="venue-gallery-modalLabel-{{ $venue->venue_id }}">Gallery of {{ Str::title($venue->name) }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($venue->venueGallery->isNotEmpty())
                                                        <div id="carouselvenueGallery{{ $venue->venue_id }}" class="carousel slide" data-bs-ride="carousel">
                                                            <div class="carousel-indicators">
                                                                @foreach ($venue->venueGallery as $index => $image)
                                                                    <button type="button" data-bs-target="#carouselvenueGallery{{ $venue->venue_id }}" 
                                                                        data-bs-slide-to="{{ $index }}" 
                                                                        class="{{ $index === 0 ? 'active' : '' }}" 
                                                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                                                                @endforeach
                                                            </div>
                                                            <div class="carousel-inner rounded">
                                                                @foreach ($venue->venueGallery as $index => $image)
                                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                        <img src="{{ asset('storage/' . $image->image_name) }}" 
                                                                            class="d-block w-100 img-fluid" 
                                                                            alt="venue Image {{ $index + 1 }}"
                                                                            style="max-height: 500px; object-fit: contain;">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselvenueGallery{{ $venue->venue_id }}" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselvenueGallery{{ $venue->venue_id }}" data-bs-slide="next">
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
        const modal = document.getElementById('venue-modal');
        const form = document.getElementById('venue-form');
        const formMethod = document.getElementById('form-method');
        const modalTitle = document.getElementById('venue-modalLabel');

        const venueNameInput = document.getElementById('venue_name');
        const categoryInput = document.getElementById('option_category_id');
        const checkInTimeInput = document.getElementById('check_in_timepickr');
        const checkOutTimeInput = document.getElementById('check_out_timepickr');
        const visitorLimitTimeInput = document.getElementById('visitor_limit_timepickr');
        const statusInput = document.getElementById('status');
        const descriptionInput = document.getElementById('description');
        const additionalOvernightPriceInput = document.getElementById('additional_overnight_price_per_pax');
        const tiersContainer = document.getElementById('tiers-container');
        const addTierButton = document.getElementById('add-tier-btn');

        let tierIndex = 0;

        const addTierField = (index = tierIndex, tier = {}) => {
            const idInput = tier.pricing_tier_id ? `<input type="hidden" name="tiers[${index}][id]" value="${tier.pricing_tier_id}">` : '';
            const tierHtml = `
                <div class="row mb-2 pricing-tier">
                    ${idInput}
                    <div class="col-md-4">
                        <input type="number" class="form-control" name="tiers[${index}][max_pax]" placeholder="Max Pax" value="${tier.max_pax || ''}">
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" name="tiers[${index}][price]" placeholder="Price" step="0.01" value="${tier.price || ''}">
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <input type="number" class="form-control me-2" name="tiers[${index}][included_overnight_pax]" placeholder="Included Overnight Pax" value="${tier.included_overnight_pax || ''}">
                        <button type="button" class="btn btn-sm btn-danger remove-tier-btn" title="Remove Tier">
                            <i class="mdi mdi-delete fs-14"></i>
                        </button>
                    </div>
                </div>
            `;
            tiersContainer.insertAdjacentHTML('beforeend', tierHtml);
            tierIndex++;
        };

        modal.addEventListener('shown.bs.modal', () => {
            if (tiersContainer.children.length === 0) {
                addTierField();
            }
        });

        modal.addEventListener('hidden.bs.modal', () => {
            form.action = "{{ route('venues.store') }}";
            formMethod.value = 'POST';
            form.reset();
            modalTitle.textContent = 'Add Venue';
            tiersContainer.innerHTML = '';
            tierIndex = 0;
            addTierField();
        });

        addTierButton.addEventListener('click', () => {
            addTierField();
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-tier-btn')) {
                e.target.closest('.pricing-tier').remove();
            } else if (e.target && e.target.closest('.remove-tier-btn')) {
                e.target.closest('.pricing-tier').remove();
            }
        });

        document.querySelectorAll('.edit-venue-btn').forEach(button => {
            button.addEventListener('click', () => {
                const venue = JSON.parse(button.getAttribute('data-venue'));
                const tiers = JSON.parse(button.getAttribute('data-tiers') || '[]');

                modalTitle.textContent = 'Edit Venue';
                form.action = "{{ route('venues.update', '') }}/" + venue.venue_id;
                formMethod.value = 'PUT';

                venueNameInput.value = venue.name || '';
                categoryInput.value = venue.option_category_id || '';
                checkInTimeInput.value = venue.check_in_time ? venue.check_in_time.slice(0, 5) : '';
                checkOutTimeInput.value = venue.check_out_time ? venue.check_out_time.slice(0, 5) : '';
                visitorLimitTimeInput.value = venue.visitor_time_limit ? venue.visitor_time_limit.slice(0, 5) : '';
                statusInput.value = venue.status || '';
                descriptionInput.value = venue.description || '';
                additionalOvernightPriceInput.value = venue.additional_overnight_price_per_pax || '';

                tiersContainer.innerHTML = '';
                if (tiers.length > 0) {
                    tiers.forEach((tier, index) => {
                        addTierField(index, tier);
                    });
                    tierIndex = tiers.length;
                } else {
                    addTierField();
                    tierIndex = 1;
                }
            });
        });
    </script>
@endsection