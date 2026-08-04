@extends('layouts.admin')

@section('title', 'Import Pincodes - Ligen Dealer Locator')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-file-import me-2"></i>Import Pincodes</h2>
                    <p class="text-muted mb-0">Import pincodes with city, state from CSV file</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pincodes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Pincodes
                    </a>
                    <a href="{{ route('admin.pincodes.template') }}" class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i>Download Template
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-flag me-2"></i>Import India Post Format (All India)</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Import all pincodes from the official <strong>All India Pincode Directory</strong> (data.gov.in). Covers all areas in India with city, district, and state.</p>
                    <div class="mb-3">
                        <a href="https://www.data.gov.in/sites/default/files/all_india_pin_code.csv" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-2"></i>Download India Post CSV from data.gov.in
                        </a>
                    </div>
                    <form action="{{ route('admin.pincodes.import.india') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="india_csv_file" class="form-label">Upload India Post CSV *</label>
                            <input type="file" class="form-control @error('csv_file') is-invalid @enderror"
                                   id="india_csv_file" name="csv_file" accept=".csv,.txt" required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum file size: 20MB. Use the CSV from data.gov.in (columns: officename, pincode, officeType, Deliverystatus, Taluk, Districtname, statename).</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Import India Post CSV
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Custom CSV</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pincodes.import.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="csv_file" class="form-label">Select CSV File *</label>
                            <input type="file" class="form-control @error('csv_file') is-invalid @enderror"
                                   id="csv_file" name="csv_file" accept=".csv,.txt" required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum file size: 5MB. Use the template format.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.pincodes.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Import CSV
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>CSV Format</h5>
                </div>
                <div class="card-body">
                    <p>Required columns: <code>pincode</code>, <code>city</code>, <code>state</code>, <code>district</code> (optional), <code>is_serviceable</code> (1 or 0)</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>pincode</th>
                                    <th>city</th>
                                    <th>state</th>
                                    <th>district</th>
                                    <th>is_serviceable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>800001</td>
                                    <td>Patna</td>
                                    <td>Bihar</td>
                                    <td>Patna</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-download me-2"></i>Template</h5>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-file-csv text-primary mb-3" style="font-size: 3rem;"></i>
                    <p class="mb-3">Download the CSV template with correct format.</p>
                    <a href="{{ route('admin.pincodes.template') }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Download Template
                    </a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.pincodes.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Single Pincode
                        </a>
                        <a href="{{ route('admin.pincodes.export') }}" class="btn btn-outline-success">
                            <i class="fas fa-download me-2"></i>Export All Pincodes
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
