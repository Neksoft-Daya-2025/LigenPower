@extends('layouts.admin')

@section('title', 'Admin Dashboard - Ligen Power® Dealer Locator')

@section('styles')
<style>
    /* Enhanced Button Styling */
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-transform: none;
        letter-spacing: 0.5px;
    }
    
    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
    
    .btn-lg:active {
        transform: translateY(0);
    }
    
    /* Primary Button Enhancement */
    .btn-primary {
        background: linear-gradient(135deg, #6c757d, #495057);
        border: none;
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #495057, #6c757d);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
    }
    
    /* Success Button Enhancement */
    .btn-success {
        background: linear-gradient(135deg, #82ac3a, #6b8a2e);
        border: none;
        box-shadow: 0 2px 8px rgba(130, 172, 58, 0.3);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #6b8a2e, #82ac3a);
        box-shadow: 0 4px 15px rgba(130, 172, 58, 0.4);
    }
    
    /* Outline Button Enhancements */
    .btn-outline-success {
        border: 2px solid #82ac3a;
        color: #82ac3a;
        background: rgba(130, 172, 58, 0.05);
    }
    
    .btn-outline-success:hover {
        background: linear-gradient(135deg, #82ac3a, #6b8a2e);
        border-color: #82ac3a;
        color: white;
        box-shadow: 0 4px 15px rgba(130, 172, 58, 0.3);
    }
    
    .btn-outline-primary {
        border: 2px solid #6c757d;
        color: #6c757d;
        background: rgba(108, 117, 125, 0.05);
    }
    
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #6c757d, #495057);
        border-color: #6c757d;
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn-outline-info {
        border: 2px solid #17a2b8;
        color: #17a2b8;
        background: rgba(23, 162, 184, 0.05);
    }
    
    .btn-outline-info:hover {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border-color: #17a2b8;
        color: white;
        box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
    }
    
    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
        background: rgba(220, 53, 69, 0.05);
    }
    
    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border-color: #dc3545;
        color: white;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    
    /* Icon Styling */
    .btn i {
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }
    
    /* Responsive Button Layout */
    @media (max-width: 768px) {
        .d-flex.gap-3 {
            gap: 0.75rem !important;
        }
        
        .btn-lg {
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
        }
    }
    
    @media (max-width: 576px) {
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .btn-lg {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
{{-- Include Smart Chatbot Component --}}
@include('components.chatbot')

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h2>
                    <p class="text-muted mb-0">Welcome, {{ Auth::guard('admin')->user()->name }}</p>
                </div>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <a href="{{ route('admin.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-plus me-2"></i>Add New Dealer
                    </a>
                    <a href="{{ route('admin.import') }}" class="btn btn-success btn-lg shadow-sm">
                        <i class="fas fa-file-import me-2"></i>Import CSV
                    </a>
                    <a href="{{ route('admin.export') }}" class="btn btn-outline-success btn-lg shadow-sm">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('admin.states.index') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                        <i class="fas fa-map me-2"></i>Manage States
                    </a>
                    <a href="{{ route('admin.districts.index') }}" class="btn btn-outline-info btn-lg shadow-sm">
                        <i class="fas fa-map-marker-alt me-2"></i>Manage Districts
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-lg shadow-sm">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users text-primary mb-2" style="font-size: 2rem;"></i>
                    <h4 class="card-title">{{ $stats['total'] }}</h4>
                    <p class="card-text">Total Registrations</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-store text-success mb-2" style="font-size: 2rem;"></i>
                    <h4 class="card-title">{{ $stats['dealers'] }}</h4>
                    <p class="card-text">Dealers</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-building text-info mb-2" style="font-size: 2rem;"></i>
                    <h4 class="card-title">{{ $stats['distributors'] }}</h4>
                    <p class="card-text">Distributors</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle text-warning mb-2" style="font-size: 2rem;"></i>
                    <h4 class="card-title">{{ $stats['active'] }}</h4>
                    <p class="card-text">Active (on locator)</p>
                </div>
            </div>
        </div>
    </div>
    @if(($stats['pending'] ?? 0) > 0)
    <div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <span><i class="fas fa-clock me-2"></i><strong>{{ $stats['pending'] }}</strong> registration(s) awaiting approval (shown as Inactive below — click <i class="fas fa-play"></i> to approve).</span>
        <a href="{{ route('register') }}" target="_blank" class="btn btn-sm btn-outline-dark">View public form</a>
    </div>
    @endif


    <!-- Dealers Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Dealers & Distributors</h5>
        </div>
        <div class="card-body">
            @if($dealers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>Contact Person</th>
                                <th>Type</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dealers as $dealer)
                                <tr>
                                    <td>
                                        <strong>{{ $dealer->business_name }}</strong>
                                        @if($dealer->website)
                                            <br><small><a href="{{ $dealer->website }}" target="_blank" class="text-decoration-none">
                                                <i class="fas fa-globe me-1"></i>Website
                                            </a></small>
                                        @endif
                                    </td>
                                    <td>{{ $dealer->contact_person }}</td>
                                    <td>
                                        <span class="badge bg-{{ $dealer->type == 'dealer' ? 'success' : 'info' }}">
                                            {{ ucfirst($dealer->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $dealer->email }}</td>
                                    <td>
                                        {{ $dealer->phone }}
                                        @if($dealer->alternate_phone)
                                            <br><small class="text-muted">Alt: {{ $dealer->alternate_phone }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $dealer->city }}{{ $dealer->district ? ', ' . $dealer->district->name : '' }}<br>
                                        <small class="text-muted">{{ $dealer->state->name ?? $dealer->state }} - {{ $dealer->pincode }}</small>
                                    </td>
                                    <td>
                                        @if($dealer->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending approval</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.edit', $dealer) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.toggle-status', $dealer) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $dealer->status == 'active' ? 'warning' : 'success' }}" 
                                                        title="{{ $dealer->status == 'active' ? 'Deactivate' : 'Approve' }}">
                                                    <i class="fas fa-{{ $dealer->status == 'active' ? 'pause' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.destroy', $dealer) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this dealer/distributor?')">
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
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $dealers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                    <h4 class="text-muted">No Dealers Found</h4>
                    <p class="text-muted">No dealers or distributors have been registered yet.</p>
                    <a href="{{ route('admin.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Dealer
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
