@extends('layouts.app')

@section('title', 'Search Dealers - Ligen Dealer Locator')

@section('content')
<!-- Hero Section -->
<div class="search-hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-5 fw-bold mb-3">Find Dealers & Distributors</h1>
                <p class="lead mb-4">Search for authorized Ligen dealers and distributors in your area</p>
            </div>
        </div>
    </div>
</div>

<!-- Search Form Section -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="search-form-card">
                <form action="{{ route('search.results') }}" method="POST" class="search-form">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label for="state_id" class="form-label">State</label>
                        <select class="form-control @error('state_id') is-invalid @enderror" id="state_id" name="state_id" required>
                            <option value="">Select your state</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="district_id" class="form-label">District/City</label>
                        <select class="form-control @error('district_id') is-invalid @enderror" id="district_id" name="district_id" required>
                            <option value="">Select your district/city</option>
                        </select>
                        @error('district_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-search">
                            <i class="fas fa-search me-2"></i>Search Dealers
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="clearForm">
                            <i class="fas fa-times me-2"></i>Clear
                        </button>
                    </div>
                </form>
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
    const clearFormBtn = document.getElementById('clearForm');
    
    // Clear form on page load to ensure fresh start
    stateSelect.value = '';
    districtSelect.innerHTML = '<option value="">Select District/City</option>';
    
    // Clear form button functionality
    clearFormBtn.addEventListener('click', function() {
        stateSelect.value = '';
        districtSelect.innerHTML = '<option value="">Select District/City</option>';
    });
    
    stateSelect.addEventListener('change', function() {
        const stateId = this.value;
        districtSelect.innerHTML = '<option value="">Select District/City</option>';
        
        if (stateId) {
            fetch(`/search/districts?state_id=${stateId}`)
                .then(response => response.json())
                .then(districts => {
                    districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading districts:', error);
                });
        }
    });
});
</script>
@endsection
