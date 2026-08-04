<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PincodeController extends Controller
{
    public function index(Request $request)
    {
        $query = Pincode::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('pincode')) {
            $query->where('pincode', 'like', '%' . $request->pincode . '%');
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }
        if ($request->filled('is_serviceable') && $request->is_serviceable !== '') {
            $query->where('is_serviceable', $request->boolean('is_serviceable'));
        }

        $pincodes = $query->orderBy('pincode')->paginate(15)->withQueryString();

        $states = config('india_states', []);
        $dbStates = Pincode::distinct()->pluck('state')->filter()->sort()->values()->toArray();
        $states = array_values(array_unique(array_merge($states, $dbStates)));

        return view('admin.pincodes.index', compact('pincodes', 'states'));
    }

    public function create()
    {
        $states = config('india_states', []);
        return view('admin.pincodes.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/|unique:pincodes,pincode',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'is_serviceable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['pincode', 'city', 'state', 'district']);
        $data['is_serviceable'] = $request->boolean('is_serviceable');

        Pincode::create($data);

        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode created successfully!');
    }

    public function edit(Pincode $pincode)
    {
        $states = config('india_states', []);
        $currentState = $pincode->state ?? '';
        if ($currentState && !in_array($currentState, $states)) {
            $states = array_merge($states, [$currentState]);
        }
        return view('admin.pincodes.edit', compact('pincode', 'states'));
    }

    public function update(Request $request, Pincode $pincode)
    {
        $validator = Validator::make($request->all(), [
            'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/|unique:pincodes,pincode,' . $pincode->id,
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'is_serviceable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['pincode', 'city', 'state', 'district']);
        $data['is_serviceable'] = $request->boolean('is_serviceable');

        $pincode->update($data);

        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode updated successfully!');
    }

    public function destroy(Pincode $pincode)
    {
        $pincode->delete();

        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode deleted successfully!');
    }

    public function toggleStatus(Pincode $pincode)
    {
        $pincode->update([
            'is_serviceable' => !$pincode->is_serviceable
        ]);

        $status = $pincode->is_serviceable ? 'marked serviceable' : 'marked non-serviceable';

        return redirect()->route('admin.pincodes.index')
            ->with('success', "Pincode {$status} successfully!");
    }

    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pincodes_export_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['pincode', 'city', 'state', 'district', 'is_serviceable']);

            Pincode::orderBy('pincode')->chunk(500, function ($pincodes) use ($file) {
                foreach ($pincodes as $p) {
                    fputcsv($file, [$p->pincode, $p->city, $p->state, $p->district ?? '', $p->is_serviceable ? '1' : '0']);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function showImport()
    {
        return view('admin.pincodes.import');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pincodes_import_template.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['pincode', 'city', 'state', 'district', 'is_serviceable']);
            fputcsv($file, ['800001', 'Patna', 'Bihar', 'Patna', '1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:5120']);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $headers = fgetcsv($handle);
        $expected = ['pincode', 'city', 'state', 'district', 'is_serviceable'];
        $headerMap = array_flip(array_map('strtolower', array_map('trim', $headers ?? [])));

        foreach ($expected as $col) {
            if (!isset($headerMap[$col])) {
                fclose($handle);
                return redirect()->back()
                    ->withErrors(['csv_file' => 'Invalid CSV format. Use the template.'])
                    ->withInput();
            }
        }

        $errors = [];
        $successCount = 0;
        $rowNum = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (empty(array_filter($data))) {
                continue;
            }

            $row = array_combine(array_map('strtolower', array_map('trim', $headers)), $data);
            $row = array_map('trim', $row ?? []);

            $validator = Validator::make($row, [
                'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'district' => 'nullable|string|max:255',
                'is_serviceable' => 'nullable|in:0,1,yes,no,true,false',
            ]);

            if ($validator->fails()) {
                $errors[] = "Row {$rowNum}: " . implode(', ', $validator->errors()->all());
                continue;
            }

            $isServiceable = in_array(strtolower($row['is_serviceable'] ?? '1'), ['1', 'yes', 'true']);

            Pincode::updateOrCreate(
                ['pincode' => $row['pincode']],
                [
                    'city' => $row['city'],
                    'state' => $row['state'],
                    'district' => $row['district'] ?? null,
                    'is_serviceable' => $isServiceable,
                ]
            );
            $successCount++;
        }

        fclose($handle);

        $msg = "{$successCount} pincode(s) imported.";
        if (!empty($errors)) {
            $msg .= ' Errors: ' . implode('; ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $msg .= '...';
            }
        }

        return redirect()->route('admin.pincodes.index')->with('success', $msg);
    }

    /**
     * Import pincodes from India Post format (data.gov.in All India Pincode Directory).
     * Columns: officename, pincode, officeType, Deliverystatus, divisionname, regionname, circlename, Taluk, Districtname, statename
     */
    public function importIndiaPost(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:20480']);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            return redirect()->back()
                ->withErrors(['csv_file' => 'Invalid or empty CSV file.'])
                ->withInput();
        }

        $headerMap = array_flip(array_map('strtolower', array_map('trim', $headers)));
        $required = ['pincode', 'districtname', 'statename'];
        foreach ($required as $col) {
            if (!isset($headerMap[$col])) {
                fclose($handle);
                return redirect()->back()
                    ->withErrors(['csv_file' => 'Invalid India Post format. Required columns: pincode, Districtname, statename. Download from data.gov.in.'])
                    ->withInput();
            }
        }

        $errors = [];
        $successCount = 0;
        $rowNum = 1;
        $seenPincodes = [];

        while (($data = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (empty(array_filter($data))) {
                continue;
            }

            $row = [];
            foreach ($headers as $i => $h) {
                $key = strtolower(trim($h));
                $row[$key] = isset($data[$i]) ? trim($data[$i]) : '';
            }

            $pincode = preg_replace('/\D/', '', $row['pincode'] ?? '');
            if (strlen($pincode) !== 6) {
                $errors[] = "Row {$rowNum}: Invalid pincode '{$row['pincode']}'";
                continue;
            }

            if (isset($seenPincodes[$pincode])) {
                continue;
            }
            $seenPincodes[$pincode] = true;

            $district = $row['districtname'] ?? '';
            $state = $row['statename'] ?? '';
            $taluk = $row['taluk'] ?? '';
            $city = $taluk !== '' ? $taluk : $district;

            if (strlen($city) > 255) {
                $city = substr($city, 0, 255);
            }
            if (strlen($state) > 255) {
                $state = substr($state, 0, 255);
            }
            if (strlen($district) > 255) {
                $district = substr($district, 0, 255);
            }

            $deliveryStatus = strtolower(trim($row['deliverystatus'] ?? 'delivery'));
            $isServiceable = ($deliveryStatus === 'delivery');

            Pincode::updateOrCreate(
                ['pincode' => $pincode],
                [
                    'city' => $city ?: $district,
                    'state' => $state ?: 'Unknown',
                    'district' => $district ?: null,
                    'is_serviceable' => $isServiceable,
                ]
            );
            $successCount++;
        }

        fclose($handle);

        $msg = "{$successCount} pincode(s) imported from India Post format.";
        if (!empty($errors)) {
            $msg .= ' Errors: ' . implode('; ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $msg .= '...';
            }
        }

        return redirect()->route('admin.pincodes.index')->with('success', $msg);
    }

    /**
     * Get pincodes by area (state, city, district). Used for "Add by Area" selection.
     */
    public function getByArea(Request $request)
    {
        $state = trim($request->get('state', ''));
        $city = trim($request->get('city', ''));
        $district = trim($request->get('district', ''));

        if (strlen($state) < 2) {
            return response()->json(['success' => false, 'message' => 'State is required', 'pincodes' => []]);
        }

        $query = Pincode::query()
            ->whereRaw('LOWER(state) LIKE ?', ['%' . strtolower($state) . '%']);

        if ($city !== '') {
            $query->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($city) . '%']);
        }
        if ($district !== '') {
            $query->whereRaw('LOWER(TRIM(COALESCE(district, ""))) LIKE ?', ['%' . strtolower(trim($district)) . '%']);
        }

        $pincodes = $query->select('id', 'pincode', 'city', 'state', 'district', 'is_serviceable')
            ->orderBy('pincode')
            ->limit(500)
            ->get();

        return response()->json([
            'success' => true,
            'pincodes' => $pincodes,
            'count' => $pincodes->count(),
        ]);
    }

    /**
     * Get distinct cities for a state. Used for area dropdown.
     */
    public function getCitiesByState(Request $request)
    {
        $state = trim($request->get('state', ''));
        if (strlen($state) < 2) {
            return response()->json(['success' => false, 'cities' => []]);
        }

        $cities = Pincode::whereRaw('LOWER(state) LIKE ?', ['%' . strtolower($state) . '%'])
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->filter()
            ->values();

        return response()->json(['success' => true, 'cities' => $cities]);
    }

    /**
     * Get distinct districts for a state. Used for area dropdown.
     */
    public function getDistrictsByState(Request $request)
    {
        $state = trim($request->get('state', ''));
        if (strlen($state) < 2) {
            return response()->json(['success' => false, 'districts' => []]);
        }

        $districts = Pincode::whereRaw('LOWER(state) LIKE ?', ['%' . strtolower($state) . '%'])
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct()
            ->orderBy('district')
            ->pluck('district')
            ->filter()
            ->values();

        return response()->json(['success' => true, 'districts' => $districts]);
    }

    /**
     * Apply selected pincodes as serviceable (mark for checkout delivery).
     */
    public function applyByArea(Request $request)
    {
        $ids = $request->input('pincode_ids', []);
        if (!is_array($ids)) {
            $ids = [];
        }
        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No pincodes selected']);
        }

        $updated = Pincode::whereIn('id', $ids)->update(['is_serviceable' => true]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} pincode(s) marked as serviceable.",
            'updated' => $updated,
        ]);
    }
}
