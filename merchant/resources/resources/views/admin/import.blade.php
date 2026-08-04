@extends('layouts.app')

@section('title', 'CSV Import - Admin Panel')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-file-import me-2"></i>CSV Import</h2>
                    <p class="text-muted mb-0">Import dealers and distributors from CSV file</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('admin.export') }}" class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('import_errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6><i class="fas fa-exclamation-circle me-2"></i>Import Errors:</h6>
                    <ul class="mb-0">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Detailed Instructions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Import Instructions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-list-ol me-2"></i>Step-by-Step Guide</h6>
                            <ol class="mb-4">
                                <li><strong>Download Template:</strong> Click "Download Template" to get the correct CSV format</li>
                                <li><strong>Prepare Data:</strong> Fill in your dealer/distributor data following the template</li>
                                <li><strong>Validate Data:</strong> Ensure all required fields are filled and data is accurate</li>
                                <li><strong>Upload File:</strong> Select your CSV file and click "Import CSV"</li>
                                <li><strong>Review Results:</strong> Check the import results and fix any errors if needed</li>
                            </ol>

                            <h6 class="text-primary mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Important Notes</h6>
                            <ul class="mb-4">
                                <li>Use exact state and district names as they appear in the system</li>
                                <li>Email addresses must be unique (no duplicates)</li>
                                <li>Phone numbers should be 10 digits without country code</li>
                                <li>Type must be either "dealer" or "distributor"</li>
                                <li>Status must be either "active" or "inactive"</li>
                                <li>Website can be any format (www.example.com, example.com, or https://example.com)</li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-table me-2"></i>CSV Format Requirements</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Field</th>
                                            <th>Required</th>
                                            <th>Format</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>business_name</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>Text (max 255 chars)</td>
                                        </tr>
                                        <tr>
                                            <td>contact_person</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>Text (max 255 chars)</td>
                                        </tr>
                                        <tr>
                                            <td>email</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>Valid email format</td>
                                        </tr>
                                        <tr>
                                            <td>phone</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>10 digits (max 15 chars)</td>
                                        </tr>
                                        <tr>
                                            <td>alternate_phone</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>10 digits (max 15 chars)</td>
                                        </tr>
                                        <tr>
                                            <td>type</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>dealer or distributor</td>
                                        </tr>
                                        <tr>
                                            <td>address</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>Text</td>
                                        </tr>
                                        <tr>
                                            <td>state_name</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>Exact state name</td>
                                        </tr>
                                        <tr>
                                            <td>district_name</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>Exact district name</td>
                                        </tr>
                                        <tr>
                                            <td>pincode</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>6 digits (max 10 chars)</td>
                                        </tr>
                                        <tr>
                                            <td>gst_number</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>15 characters</td>
                                        </tr>
                                        <tr>
                                            <td>pan_number</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>10 characters</td>
                                        </tr>
                                        <tr>
                                            <td>business_description</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>Text</td>
                                        </tr>
                                        <tr>
                                            <td>website</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>Any text (e.g., www.example.com)</td>
                                        </tr>
                                        <tr>
                                            <td>status</td>
                                            <td><span class="badge bg-secondary">No</span></td>
                                            <td>active or inactive</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3"><i class="fas fa-question-circle me-2"></i>Common Issues & Solutions</h6>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                            State/District not found error
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <strong>Solution:</strong> Use exact state and district names as they appear in the system. 
                                            Check the "Manage States" and "Manage Districts" sections to see available options. 
                                            Names are case-sensitive and must match exactly.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                            Email already exists error
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <strong>Solution:</strong> Each email address must be unique. If you're updating existing data, 
                                            use the edit function instead of importing. For new data, ensure all email addresses are unique.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                            Invalid CSV format error
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <strong>Solution:</strong> Download the template and use it as your base. Ensure all column headers 
                                            match exactly. Save your file as CSV format (not Excel). Use UTF-8 encoding if possible.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                            Large file upload issues
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <strong>Solution:</strong> The maximum file size is 2MB. For large datasets, split your data into 
                                            multiple smaller files and import them separately. This also helps with error tracking.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Form and Template -->
    <div class="row">
        <!-- Import Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload CSV File</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.import.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="csv_file" class="form-label">Select CSV File *</label>
                            <input type="file" class="form-control @error('csv_file') is-invalid @enderror" 
                                   id="csv_file" name="csv_file" accept=".csv,.txt" required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Maximum file size: 2MB. Supported formats: CSV, TXT
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Import CSV
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions & Template -->
        <div class="col-lg-4">
            <!-- Template Download -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-download me-2"></i>CSV Template</h5>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-file-csv text-primary mb-3" style="font-size: 3rem;"></i>
                    <p class="mb-3">Download the CSV template with the correct format and sample data.</p>
                    <a href="{{ route('admin.template') }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Download Template
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Single Dealer
                        </a>
                        <a href="{{ route('admin.export') }}" class="btn btn-outline-success">
                            <i class="fas fa-download me-2"></i>Export All Data
                        </a>
                        <a href="{{ route('admin.states.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-map me-2"></i>Manage States
                        </a>
                        <a href="{{ route('admin.districts.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-map-marker-alt me-2"></i>Manage Districts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input validation
    const fileInput = document.getElementById('csv_file');
    
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
                return;
            }
            
            // Check file extension
            const allowedExtensions = ['.csv', '.txt'];
            const fileName = file.name.toLowerCase();
            const hasValidExtension = allowedExtensions.some(ext => fileName.endsWith(ext));
            
            if (!hasValidExtension) {
                alert('Please select a CSV or TXT file');
                this.value = '';
                return;
            }
        }
    });
});
</script>
@endsection
