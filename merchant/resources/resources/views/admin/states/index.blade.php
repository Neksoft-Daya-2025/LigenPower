@extends('layouts.app')

@section('title', 'Manage States - Ligen Dealer Locator')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-map me-2"></i>Manage States</h2>
                    <p class="text-muted mb-0">Add and manage states for dealer locations</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.states.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New State
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

    <!-- States Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>All States</h5>
        </div>
        <div class="card-body">
            @if($states->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($states as $state)
                                <tr>
                                    <td>
                                        <strong>{{ $state->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $state->code }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $state->is_active ? 'success' : 'secondary' }}">
                                            {{ $state->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $state->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.states.edit', $state) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.states.toggle-status', $state) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $state->is_active ? 'warning' : 'success' }}" 
                                                        title="{{ $state->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $state->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.states.destroy', $state) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this state?')">
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
                    {{ $states->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-map text-muted mb-3" style="font-size: 3rem;"></i>
                    <h4 class="text-muted">No States Found</h4>
                    <p class="text-muted">No states have been added yet.</p>
                    <a href="{{ route('admin.states.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First State
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
