@extends('layouts.admin')

@section('title', 'Manage Pincodes - Ligen Dealer Locator')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-map-pin me-2"></i>Manage Pincodes by City</h2>
                    <p class="text-muted mb-0">Add and manage pincodes with city, state for checkout & delivery</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.pincodes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Pincode
                    </a>
                    <a href="{{ route('admin.pincodes.import') }}" class="btn btn-success">
                        <i class="fas fa-file-import me-2"></i>Import CSV
                    </a>
                    <a href="{{ route('admin.pincodes.export') }}" class="btn btn-outline-success">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add by Area -->
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Add Pincodes by Area</h5>
        </div>
        <div class="card-body">
            <p class="text-muted small mb-3">Select an area (state, city, district) to load pincodes. Import India Post CSV first if you have no data. Then select pincodes and apply to mark them as serviceable for checkout.</p>
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">State *</label>
                    <select id="area-state" class="form-select">
                        <option value="">Select state</option>
                        @foreach($states ?? [] as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">City</label>
                    <select id="area-city" class="form-select">
                        <option value="">Select city</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">District</label>
                    <select id="area-district" class="form-select">
                        <option value="">Select district</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="area-load-btn" class="btn btn-primary w-100" disabled>
                        <i class="fas fa-search me-2"></i>Load Pincodes
                    </button>
                </div>
            </div>
            <div id="area-results" class="d-none">
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span id="area-count" class="text-muted">0 pincodes found</span>
                    <button type="button" id="area-apply-btn" class="btn btn-success btn-sm">
                        <i class="fas fa-check-double me-1"></i>Apply selected as serviceable
                    </button>
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm table-striped">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th><input type="checkbox" id="area-select-all" title="Select all"></th>
                                <th>Pincode</th>
                                <th>City</th>
                                <th>District</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="area-pincodes-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Search/Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pincodes.index') }}" class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="pincode" class="form-control" placeholder="Pincode" value="{{ request('pincode') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="city" class="form-control" placeholder="City" value="{{ request('city') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="state" class="form-control" placeholder="State" value="{{ request('state') }}">
                </div>
                <div class="col-md-2">
                    <select name="is_serviceable" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('is_serviceable') === '1' ? 'selected' : '' }}>Serviceable</option>
                        <option value="0" {{ request('is_serviceable') === '0' ? 'selected' : '' }}>Not Serviceable</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pincodes Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Pincodes</h5>
        </div>
        <div class="card-body">
            @if($pincodes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pincode</th>
                                <th>City</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Serviceable</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pincodes as $p)
                                <tr>
                                    <td><strong>{{ $p->pincode }}</strong></td>
                                    <td>{{ $p->city }}</td>
                                    <td><span class="badge bg-info">{{ $p->state }}</span></td>
                                    <td>{{ $p->district ?? '–' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $p->is_serviceable ? 'success' : 'secondary' }}">
                                            {{ $p->is_serviceable ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>{{ $p->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.pincodes.edit', $p) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.pincodes.toggle-status', $p) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $p->is_serviceable ? 'warning' : 'success' }}"
                                                        title="{{ $p->is_serviceable ? 'Mark non-serviceable' : 'Mark serviceable' }}">
                                                    <i class="fas fa-{{ $p->is_serviceable ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.pincodes.destroy', $p) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this pincode?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $pincodes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-map-pin text-muted mb-3" style="font-size: 3rem;"></i>
                    <h4 class="text-muted">No Pincodes Found</h4>
                    <p class="text-muted">Add pincodes with city and state for checkout delivery areas.</p>
                    <a href="{{ route('admin.pincodes.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Add First Pincode
                    </a>
                    <a href="{{ route('admin.pincodes.import') }}" class="btn btn-success">
                        <i class="fas fa-file-import me-2"></i>Import CSV
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function() {
    const baseUrl = '{{ url("/admin") }}';
    const csrfToken = '{{ csrf_token() }}';
    const areaState = document.getElementById('area-state');
    const areaCity = document.getElementById('area-city');
    const areaDistrict = document.getElementById('area-district');
    const areaLoadBtn = document.getElementById('area-load-btn');
    const areaResults = document.getElementById('area-results');
    const areaCount = document.getElementById('area-count');
    const areaTbody = document.getElementById('area-pincodes-tbody');
    const areaSelectAll = document.getElementById('area-select-all');
    const areaApplyBtn = document.getElementById('area-apply-btn');

    let loadedPincodes = [];

    areaState.addEventListener('change', function() {
        const state = this.value;
        areaCity.innerHTML = '<option value="">Select city</option>';
        areaDistrict.innerHTML = '<option value="">Select district</option>';
        areaResults.classList.add('d-none');
        areaLoadBtn.disabled = !state;

        if (!state) return;

        Promise.all([
            fetch(baseUrl + '/pincodes/cities-by-state?state=' + encodeURIComponent(state)).then(r => r.json()),
            fetch(baseUrl + '/pincodes/districts-by-state?state=' + encodeURIComponent(state)).then(r => r.json())
        ]).then(([citiesRes, districtsRes]) => {
            if (citiesRes.success && citiesRes.cities) {
                citiesRes.cities.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c;
                    opt.textContent = c;
                    areaCity.appendChild(opt);
                });
            }
            if (districtsRes.success && districtsRes.districts) {
                districtsRes.districts.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d;
                    opt.textContent = d;
                    areaDistrict.appendChild(opt);
                });
            }
        });
    });

    areaLoadBtn.addEventListener('click', function() {
        const state = areaState.value;
        if (!state) return;

        areaLoadBtn.disabled = true;
        areaLoadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

        const params = new URLSearchParams({ state });
        if (areaCity.value) params.set('city', areaCity.value);
        if (areaDistrict.value) params.set('district', areaDistrict.value);

        fetch(baseUrl + '/pincodes/by-area?' + params.toString())
            .then(r => r.json())
            .then(data => {
                areaLoadBtn.disabled = false;
                areaLoadBtn.innerHTML = '<i class="fas fa-search me-2"></i>Load Pincodes';

                if (!data.success) {
                    alert(data.message || 'Failed to load pincodes');
                    return;
                }

                loadedPincodes = data.pincodes || [];
                areaCount.textContent = loadedPincodes.length + ' pincode(s) found';
                areaTbody.innerHTML = '';

                loadedPincodes.forEach(p => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = '<td><input type="checkbox" class="area-pincode-cb" value="' + p.id + '"></td>' +
                        '<td><strong>' + p.pincode + '</strong></td>' +
                        '<td>' + (p.city || '') + '</td>' +
                        '<td>' + (p.district || '–') + '</td>' +
                        '<td><span class="badge bg-' + (p.is_serviceable ? 'success' : 'secondary') + '">' + (p.is_serviceable ? 'Yes' : 'No') + '</span></td>';
                    areaTbody.appendChild(tr);
                });

                areaResults.classList.remove('d-none');
                areaSelectAll.checked = false;
            })
            .catch(() => {
                areaLoadBtn.disabled = false;
                areaLoadBtn.innerHTML = '<i class="fas fa-search me-2"></i>Load Pincodes';
                alert('Failed to load pincodes');
            });
    });

    areaSelectAll.addEventListener('change', function() {
        document.querySelectorAll('.area-pincode-cb').forEach(cb => cb.checked = this.checked);
    });

    areaApplyBtn.addEventListener('click', function() {
        const ids = Array.from(document.querySelectorAll('.area-pincode-cb:checked')).map(cb => cb.value);
        if (ids.length === 0) {
            alert('Select at least one pincode');
            return;
        }

        areaApplyBtn.disabled = true;
        areaApplyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Applying...';

        fetch(baseUrl + '/pincodes/apply-by-area', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ pincode_ids: ids })
        })
        .then(r => r.json())
        .then(data => {
            areaApplyBtn.disabled = false;
            areaApplyBtn.innerHTML = '<i class="fas fa-check-double me-1"></i>Apply selected as serviceable';
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Failed to apply');
            }
        })
        .catch(() => {
            areaApplyBtn.disabled = false;
            areaApplyBtn.innerHTML = '<i class="fas fa-check-double me-1"></i>Apply selected as serviceable';
            alert('Failed to apply');
        });
    });
})();
</script>
@endsection
