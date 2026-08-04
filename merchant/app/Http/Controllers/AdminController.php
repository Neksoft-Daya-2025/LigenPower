<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dealers = Dealer::with(['state', 'district'])->orderBy('created_at', 'desc')->paginate(10);
        $stats = [
            'total' => Dealer::count(),
            'dealers' => Dealer::byType('dealer')->count(),
            'distributors' => Dealer::byType('distributor')->count(),
            'active' => Dealer::active()->count(),
            'pending' => Dealer::where('status', 'inactive')->count(),
        ];
        
        return view('admin.dashboard', compact('dealers', 'stats'));
    }

    public function create()
    {
        $states = State::active()->orderBy('name')->get();
        return view('admin.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Dealer::validationRules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get district and state names for city and state fields
        $district = District::find($request->district_id);
        $state = State::find($request->state_id);
        
        $data = $request->all();
        $data['city'] = $district ? $district->name : null;
        $data['state'] = $state ? $state->name : null;
        
        // Handle empty email field
        if (empty($data['email'])) {
            $data['email'] = null;
        }

        $data['status'] = $request->input('status', 'active');

        Dealer::create($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Dealer/Distributor created successfully!');
    }

    public function edit(Dealer $dealer)
    {
        $states = State::active()->orderBy('name')->get();
        $districts = District::active()->byState($dealer->state_id)->orderBy('name')->get();
        return view('admin.edit', compact('dealer', 'states', 'districts'));
    }

    public function update(Request $request, Dealer $dealer)
    {
        $validator = Validator::make($request->all(), Dealer::updateValidationRules($dealer->id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get district and state names for city and state fields
        $district = District::find($request->district_id);
        $state = State::find($request->state_id);
        
        $data = $request->all();
        $data['city'] = $district ? $district->name : null;
        $data['state'] = $state ? $state->name : null;
        
        // Handle empty email field
        if (empty($data['email'])) {
            $data['email'] = null;
        }

        $dealer->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Dealer/Distributor updated successfully!');
    }

    public function destroy(Dealer $dealer)
    {
        $dealer->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Dealer/Distributor deleted successfully!');
    }

    public function toggleStatus(Dealer $dealer)
    {
        $dealer->update([
            'status' => $dealer->status === 'active' ? 'inactive' : 'active'
        ]);

        $status = $dealer->status === 'active' ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.dashboard')
            ->with('success', "Dealer/Distributor {$status} successfully!");
    }

    public function showImport()
    {
        return view('admin.import');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="dealers_import_template.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            // CSV Headers
            fputcsv($file, [
                'business_name',
                'contact_person', 
                'email',
                'phone',
                'alternate_phone',
                'type',
                'address',
                'state_name',
                'district_name',
                'pincode',
                'gst_number',
                'pan_number',
                'business_description',
                'website',
                'status'
            ]);

            // Sample data row
            fputcsv($file, [
                'Sample Business Name',
                'John Doe',
                'john@example.com',
                '9876543210',
                '9876543211',
                'dealer',
                '123 Main Street, Area Name',
                'Bihar',
                'Patna',
                '800001',
                '12ABCDE1234F1Z5',
                'ABCDE1234F',
                'Sample business description',
                'https://example.com',
                'active'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="dealers_export_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            // CSV Headers
            fputcsv($file, [
                'ID',
                'Business Name',
                'Contact Person',
                'Email',
                'Phone',
                'Alternate Phone',
                'Type',
                'Address',
                'State',
                'District',
                'Pincode',
                'GST Number',
                'PAN Number',
                'Business Description',
                'Website',
                'Status',
                'Created At',
                'Updated At'
            ]);

            // Export all dealers
            $dealers = Dealer::with(['state', 'district'])->get();
            
            foreach ($dealers as $dealer) {
                fputcsv($file, [
                    $dealer->id,
                    $dealer->business_name,
                    $dealer->contact_person,
                    $dealer->email,
                    $dealer->phone,
                    $dealer->alternate_phone,
                    $dealer->type,
                    $dealer->address,
                    $dealer->state->name ?? $dealer->state,
                    $dealer->district->name ?? $dealer->city,
                    $dealer->pincode,
                    $dealer->gst_number,
                    $dealer->pan_number,
                    $dealer->business_description,
                    $dealer->website,
                    $dealer->status,
                    $dealer->created_at->format('Y-m-d H:i:s'),
                    $dealer->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        
        // Skip BOM if present
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $headers = fgetcsv($handle);
        $errors = [];
        $successCount = 0;
        $rowNumber = 1;

        // Validate headers
        $expectedHeaders = [
            'business_name', 'contact_person', 'email', 'phone', 'alternate_phone',
            'type', 'address', 'state_name', 'district_name', 'pincode',
            'gst_number', 'pan_number', 'business_description', 'website', 'status'
        ];

        if (array_diff($expectedHeaders, $headers)) {
            return redirect()->back()
                ->withErrors(['csv_file' => 'Invalid CSV format. Please download the template and use the correct format.'])
                ->withInput();
        }

        while (($data = fgetcsv($handle)) !== false) {
            $rowNumber++;
            
            // Skip empty rows
            if (empty(array_filter($data))) {
                continue;
            }

            // Map CSV data to array
            $rowData = array_combine($headers, $data);
            
            // Find state and district
            $state = State::where('name', $rowData['state_name'])->first();
            $district = null;
            
            if ($state) {
                $district = District::where('name', $rowData['district_name'])
                    ->where('state_id', $state->id)
                    ->first();
            }

            if (!$state) {
                $errors[] = "Row {$rowNumber}: State '{$rowData['state_name']}' not found.";
                continue;
            }

            if (!$district) {
                $errors[] = "Row {$rowNumber}: District '{$rowData['district_name']}' not found in state '{$rowData['state_name']}'.";
                continue;
            }

            // Prepare data for validation
            $dealerData = [
                'business_name' => $rowData['business_name'],
                'contact_person' => $rowData['contact_person'],
                'email' => $rowData['email'] ?: null,
                'phone' => $rowData['phone'],
                'alternate_phone' => $rowData['alternate_phone'] ?: null,
                'type' => $rowData['type'],
                'address' => $rowData['address'],
                'state_id' => $state->id,
                'district_id' => $district->id,
                'pincode' => $rowData['pincode'],
                'gst_number' => $rowData['gst_number'] ?: null,
                'pan_number' => $rowData['pan_number'] ?: null,
                'business_description' => $rowData['business_description'] ?: null,
                'website' => $rowData['website'] ?: null,
                'status' => $rowData['status'] ?: 'active',
                'city' => $district->name,
                'state' => $state->name
            ];

            // Validate data
            $validator = Validator::make($dealerData, Dealer::validationRules());

            if ($validator->fails()) {
                $errorMessages = $validator->errors()->all();
                foreach ($errorMessages as $message) {
                    $errors[] = "Row {$rowNumber}: {$message}";
                }
                continue;
            }

            // Check for duplicate email
            if ($dealerData['email'] && Dealer::where('email', $dealerData['email'])->exists()) {
                $errors[] = "Row {$rowNumber}: Email '{$dealerData['email']}' already exists.";
                continue;
            }

            try {
                Dealer::create($dealerData);
                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Row {$rowNumber}: " . $e->getMessage();
            }
        }

        fclose($handle);

        if (count($errors) > 0) {
            $message = "Import completed with errors. {$successCount} records imported successfully. " . count($errors) . " errors found.";
            return redirect()->back()
                ->with('warning', $message)
                ->with('import_errors', $errors);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', "CSV import completed successfully! {$successCount} dealers/distributors imported.");
    }
}
