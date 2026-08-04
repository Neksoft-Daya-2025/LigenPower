@extends('layouts.app')

@section('title', 'Search Results - Ligen Dealer Locator')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card search-results-card">
                <div class="card-header search-results-header">
                    <h3 class="mb-0">
                        <i class="fas fa-search me-2"></i>Search Results
                    </h3>
                    <p class="mb-0 mt-2 opacity-75">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $results->first()->state->name ?? 'Selected State' }}, {{ $results->first()->district->name ?? 'Selected District' }}
                    </p>
                </div>
                <div class="card-body">
                    @if($results->count() > 0)
                        <div class="row">
                            @foreach($results as $dealer)
                                <div class="col-md-6 mb-4">
                                    <div class="card dealer-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="card-title">{{ $dealer->business_name }}</h5>
                                                <span class="badge badge-type">{{ ucfirst($dealer->type) }}</span>
                                            </div>
                                            
                                            <div class="dealer-info">
                                                <i class="fas fa-user"></i>
                                                <strong>Contact:</strong> {{ $dealer->contact_person }}
                                            </div>
                                            
                                            <div class="dealer-info">
                                                <i class="fas fa-phone"></i>
                                                <strong>Phone:</strong> {{ $dealer->phone }}
                                                @if($dealer->alternate_phone)
                                                    <br><small class="text-muted ms-4">Alt: {{ $dealer->alternate_phone }}</small>
                                                @endif
                                            </div>
                                            
                                            @if($dealer->email)
                                                <div class="dealer-info">
                                                    <i class="fas fa-envelope"></i>
                                                    <strong>Email:</strong> 
                                                    <a href="mailto:{{ $dealer->email }}" class="text-decoration-none">{{ $dealer->email }}</a>
                                                </div>
                                            @endif
                                            
                                            <div class="dealer-info">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <strong>Address:</strong><br>
                                                <span class="ms-4">{{ $dealer->address }}<br>
                                                {{ $dealer->city }}{{ $dealer->district ? ', ' . $dealer->district->name : '' }}, {{ $dealer->state->name ?? $dealer->state }} - {{ $dealer->pincode }}</span>
                                            </div>
                                            
                                            @if($dealer->website)
                                                <div class="dealer-info">
                                                    <i class="fas fa-globe"></i>
                                                    <strong>Website:</strong> 
                                                    <a href="{{ $dealer->website }}" target="_blank" class="text-decoration-none text-primary">
                                                        Visit Website
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            @if($dealer->business_description)
                                                <div class="dealer-info">
                                                    <i class="fas fa-info-circle"></i>
                                                    <strong>Description:</strong><br>
                                                    <span class="ms-4 small text-muted">{{ Str::limit($dealer->business_description, 100) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-results-section">
                            <i class="fas fa-search" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mb-3">No Results Found</h4>
                            <p class="text-muted mb-4">
                                No dealers or distributors found in the selected state and district.
                            </p>
                            <a href="{{ route('search.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Search Again
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card sidebar-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Search Again</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('search.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>New Search
                    </a>
                </div>
            </div>
            
            @if($results->count() > 0)
                <div class="card sidebar-card mt-3">
                    <div class="card-body">
                        <div class="results-summary">
                            <h6 class="mb-2">Search Summary</h6>
                            <p class="mb-1"><strong>{{ $results->count() }}</strong> {{ $results->count() == 1 ? 'result' : 'results' }} found</p>
                            <small class="text-muted">Dealer registration is managed by administrators only.</small>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
