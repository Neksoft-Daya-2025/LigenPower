@extends('layouts.app')

@section('title', 'Manage Districts - Ligen Dealer Locator')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-map-marker-alt me-2"></i>Manage Districts</h2>
                    <p class="text-muted mb-0">Add and manage districts for dealer locations</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.districts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New District
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

    <!-- Districts Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Districts</h5>
        </div>
        <div class="card-body">
            @if($districts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>District Name</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($districts as $district)
                                <tr>
                                    <td>
                                        <strong>{{ $district->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $district->state->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $district->is_active ? 'success' : 'secondary' }}">
                                            {{ $district->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $district->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.districts.edit', $district) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.districts.toggle-status', $district) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $district->is_active ? 'warning' : 'success' }}" 
                                                        title="{{ $district->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $district->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.districts.destroy', $district) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this district?')">
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
                    {{ $districts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-map-marker-alt text-muted mb-3" style="font-size: 3rem;"></i>
                    <h4 class="text-muted">No Districts Found</h4>
                    <p class="text-muted">No districts have been added yet.</p>
                    <a href="{{ route('admin.districts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First District
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
