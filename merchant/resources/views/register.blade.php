@extends('layouts.app')

@section('title', 'Register as Merchant - Ligen Power®')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #33766c, #82ac3a);">
                    <h3 class="mb-1"><i class="fas fa-store me-2"></i>Register as Merchant</h3>
                    <p class="mb-0 small opacity-90">Apply to become an authorized Ligen Power® dealer or distributor. Your listing goes live after admin approval.</p>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST" id="merchant-register-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="business_name" class="form-label">Business Name *</label>
                                <input type="text" class="form-control" id="business_name" name="business_name" value="{{ old('business_name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_person" class="form-label">Contact Person *</label>
                                <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type *</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="dealer" {{ old('type') == 'dealer' ? 'selected' : '' }}>Dealer</option>
                                    <option value="distributor" {{ old('type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="alternate_phone" class="form-label">Alternate Phone</label>
                                <input type="tel" class="form-control" id="alternate_phone" name="alternate_phone" value="{{ old('alternate_phone') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="state_id" class="form-label">State *</label>
                                <select class="form-select" id="state_id" name="state_id" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="district_id" class="form-label">District *</label>
                                <select class="form-select" id="district_id" name="district_id" required>
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pincode" class="form-label">Pincode *</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode') }}" maxlength="10" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gst_number" class="form-label">GST Number</label>
                                <input type="text" class="form-control" id="gst_number" name="gst_number" value="{{ old('gst_number') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pan_number" class="form-label">PAN Number</label>
                                <input type="text" class="form-control" id="pan_number" name="pan_number" value="{{ old('pan_number') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="text" class="form-control" id="website" name="website" value="{{ old('website') }}" placeholder="www.example.com">
                        </div>
                        <div class="mb-3">
                            <label for="business_description" class="form-label">About your business</label>
                            <textarea class="form-control" id="business_description" name="business_description" rows="3" placeholder="Products you sell, service areas, experience with power/solar products…">{{ old('business_description') }}</textarea>
                        </div>
                        <div class="alert alert-light border small mb-4">
                            <i class="fas fa-info-circle text-success me-1"></i>
                            After you submit, an admin will review your application. Once approved, customers can find you on
                            <a href="{{ route('search.index') }}">Find Merchant</a> and on <a href="https://ligenpower.com/" target="_blank" rel="noopener">ligenpower.com</a>.
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Home</a>
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="fas fa-paper-plane me-2"></i>Submit Registration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_id');
    const districtSelect = document.getElementById('district_id');

    function loadDistricts(stateId, selectedId) {
        districtSelect.innerHTML = '<option value="">Select District</option>';
        if (!stateId) return;
        fetch('{{ url('/api/districts') }}?state_id=' + encodeURIComponent(stateId))
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                data.districts.forEach(function(d) {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name;
                    if (selectedId && String(d.id) === String(selectedId)) opt.selected = true;
                    districtSelect.appendChild(opt);
                });
            });
    }

    stateSelect.addEventListener('change', function() {
        loadDistricts(this.value, null);
    });

    if (stateSelect.value) {
        loadDistricts(stateSelect.value, '{{ old('district_id') }}');
    }
});
</script>
@endsection
