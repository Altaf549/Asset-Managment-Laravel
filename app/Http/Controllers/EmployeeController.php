<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AssetAssignment;
use App\Models\Asset;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $statusFilter = $request->get('status_filter', 'all');
            
            $query = Employee::query();
            
            // Apply status filter
            if ($statusFilter === 'active') {
                $query->where('status', true);
            } elseif ($statusFilter === 'inactive') {
                $query->where('status', false);
            }
            
            $employees = $query->orderBy('created_at', 'desc')->get();
            return response()->json(['data' => $employees]);
        }

        return view('employees.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email',
            'phone' => 'nullable|string',
            'department' => 'nullable|string',
            'position' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'address' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $employee = Employee::create($validated);

        return response()->json(['success' => true, 'message' => 'Employee created successfully', 'employee' => $employee]);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email,' . $id,
            'phone' => 'nullable|string',
            'department' => 'nullable|string',
            'position' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'address' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $employee->update($validated);

        return response()->json(['success' => true, 'message' => 'Employee updated successfully', 'employee' => $employee]);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['success' => true, 'message' => 'Employee deleted successfully']);
    }

    public function toggleStatus(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function getAssets($id)
    {
        $employee = Employee::findOrFail($id);
        
        $assets = AssetAssignment::where('assigned_to', $id)
            ->where('status', 'assigned')
            ->with(['asset' => function($query) {
                $query->select('*');
            }])
            ->get()
            ->map(function($assignment) {
                $asset = $assignment->asset;
                return [
                    'id' => $asset->id,
                    'asset_id' => $asset->asset_id,
                    'asset_type' => $asset->asset_type,
                    'serial_number' => $asset->serial_number,
                    'model_name' => $asset->model_name,
                    'manufacturer' => $asset->manufacturer,
                    'cabinet_name' => $asset->cabinet_name,
                    'screen_size' => $asset->screen_size,
                    'resolution' => $asset->resolution,
                    'hdmi_or_vga' => $asset->hdmi_or_vga,
                    'ram' => $asset->ram,
                    'ram_model' => $asset->ram_model,
                    'ram_fsb' => $asset->ram_fsb,
                    'ssd' => $asset->ssd,
                    'hard_disk' => $asset->hard_disk,
                    'processor_company' => $asset->processor_company,
                    'processor' => $asset->processor,
                    'processor_generation' => $asset->processor_generation,
                    'motherboard' => $asset->motherboard,
                    'motherboard_model' => $asset->motherboard_model,
                    'keyboard_type' => $asset->keyboard_type,
                    'mouse_type' => $asset->mouse_type,
                    'title' => $asset->title,
                    'purchase_date' => $asset->purchase_date,
                    'vendor_name' => $asset->vendor_name,
                    'purchase_type' => $asset->purchase_type,
                    'assigned_date' => $assignment->assigned_date,
                    'notes' => $assignment->notes,
                    'status' => $asset->status,
                    'created_at' => $asset->created_at,
                    'updated_at' => $asset->updated_at
                ];
            });

        return response()->json([
            'employee' => $employee,
            'assets' => $assets
        ]);
    }

    private function getAssetNameModel($asset)
    {
        switch($asset->asset_type) {
            case 'laptop':
            case 'mac':
                return $asset->model_name ?: $asset->serial_number ?: $asset->asset_id;
            case 'cpu':
                return $asset->cabinet_name ?: $asset->asset_id;
            case 'monitor':
            case 'keyboard':
            case 'mouse':
                return $asset->manufacturer ?: $asset->asset_id;
            case 'other':
                return $asset->title ?: $asset->asset_id;
            default:
                return $asset->asset_id;
        }
    }
}
