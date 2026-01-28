<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\AssignHistory;
use App\Models\UnassignHistory;
use App\Exports\AssetsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index(Request $request, $type)
    {
        if ($request->ajax()) {
            $assets = Asset::where('asset_type', $type)
                ->with(['assignments' => function ($query) {
                    $query->where('status', 'assigned')->latest()->first();
                }])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($asset) {
                    $currentAssignment = $asset->assignments()->where('status', 'assigned')->latest()->first();
                    $asset->assigned_to_name = $currentAssignment ? $currentAssignment->assignedTo->name : null;
                    $asset->assigned_to_id = $currentAssignment ? $currentAssignment->assigned_to : null;
                    return $asset;
                });

            return response()->json(['data' => $assets]);
        }

        return view('assets.index', compact('type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_type' => 'required|string',
            'asset_id' => 'required|string|unique:assets,asset_id',
            'serial_number' => 'nullable|string',
            'model_name' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'cabinet_name' => 'nullable|string',
            'screen_size' => 'nullable|string',
            'resolution' => 'nullable|string',
            'hdmi_or_vga' => 'nullable|string',
            'ram' => 'nullable|string',
            'ram_model' => 'nullable|string',
            'ram_fsb' => 'nullable|string',
            'ssd' => 'nullable|string',
            'hard_disk' => 'nullable|string',
            'processor_company' => 'nullable|string',
            'processor' => 'nullable|string',
            'processor_generation' => 'nullable|string',
            'motherboard' => 'nullable|string',
            'motherboard_model' => 'nullable|string',
            'keyboard_type' => 'nullable|string',
            'mouse_type' => 'nullable|string',
            'title' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'vendor_name' => 'nullable|string',
            'purchase_type' => 'nullable|string',
            'emp_id' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $asset = Asset::create($validated);

        return response()->json(['success' => true, 'message' => 'Asset created successfully', 'asset' => $asset]);
    }

    public function show($id)
    {
        $asset = Asset::with(['assignments.assignedTo'])->findOrFail($id);
        return response()->json($asset);
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'asset_id' => 'required|string|unique:assets,asset_id,' . $id,
            'serial_number' => 'nullable|string',
            'model_name' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'cabinet_name' => 'nullable|string',
            'screen_size' => 'nullable|string',
            'resolution' => 'nullable|string',
            'hdmi_or_vga' => 'nullable|string',
            'ram' => 'nullable|string',
            'ram_model' => 'nullable|string',
            'ram_fsb' => 'nullable|string',
            'ssd' => 'nullable|string',
            'hard_disk' => 'nullable|string',
            'processor_company' => 'nullable|string',
            'processor' => 'nullable|string',
            'processor_generation' => 'nullable|string',
            'motherboard' => 'nullable|string',
            'motherboard_model' => 'nullable|string',
            'keyboard_type' => 'nullable|string',
            'mouse_type' => 'nullable|string',
            'title' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'vendor_name' => 'nullable|string',
            'purchase_type' => 'nullable|string',
            'emp_id' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $asset->update($validated);

        return response()->json(['success' => true, 'message' => 'Asset updated successfully', 'asset' => $asset]);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json(['success' => true, 'message' => 'Asset deleted successfully']);
    }

    public function toggleStatus(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->status = $request->status;
        $asset->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function assign(Request $request, $id)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:employees,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $asset = Asset::findOrFail($id);

        // Check if asset is active
        if (!$asset->status) {
            return response()->json(['success' => false, 'message' => 'Cannot assign inactive asset. Please activate the asset first.'], 400);
        }

        // Check if already assigned
        $existingAssignment = AssetAssignment::where('asset_id', $id)
            ->where('status', 'assigned')
            ->first();

        if ($existingAssignment) {
            return response()->json(['success' => false, 'message' => 'Asset is already assigned'], 400);
        }

        // Create assignment record for current assignment
        $assignment = AssetAssignment::create([
            'asset_id' => $id,
            'assigned_to' => $validated['assigned_to'],
            'assigned_by' => Auth::id(),
            'assigned_date' => $validated['assigned_date'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'assigned',
        ]);

        // Store in assign_history table for permanent history
        AssignHistory::create([
            'asset_id' => $id,
            'assigned_to' => $validated['assigned_to'],
            'assigned_by' => Auth::id(),
            'assigned_date' => $validated['assigned_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Asset assigned successfully', 'assignment' => $assignment]);
    }

    public function unassign(Request $request, $id)
    {
        $validated = $request->validate([
            'returned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $assignment = AssetAssignment::where('asset_id', $id)
            ->where('status', 'assigned')
            ->firstOrFail();

        // Store in unassign_history table for permanent history
        UnassignHistory::create([
            'asset_id' => $id,
            'assigned_to' => $assignment->assigned_to,
            'assigned_by' => $assignment->assigned_by,
            'assigned_date' => $assignment->assigned_date,
            'returned_date' => $validated['returned_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Delete the current assignment record (history is preserved in unassign_history)
        $assignment->delete();

        return response()->json(['success' => true, 'message' => 'Asset unassigned successfully']);
    }

    public function assignHistory($type)
    {
        // Get all assignment history from assign_history table
        $assignments = AssignHistory::whereHas('asset', function ($query) use ($type) {
            $query->where('asset_type', $type);
        })
            ->with(['asset', 'assignedTo', 'assignedBy'])
            ->orderBy('assigned_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('assets.assign-history', compact('assignments', 'type'));
    }

    public function unassignHistory($type)
    {
        // Get all unassign history from unassign_history table
        $assignments = UnassignHistory::whereHas('asset', function ($query) use ($type) {
            $query->where('asset_type', $type);
        })
            ->with(['asset', 'assignedTo', 'assignedBy'])
            ->orderBy('returned_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('assets.unassign-history', compact('assignments', 'type'));
    }

    public function export($type)
    {
        $fileName = ucfirst($type) . '_Assets_' . date('Y-m-d_His') . '.xlsx';
        return Excel::download(new AssetsExport($type), $fileName);
    }
}
