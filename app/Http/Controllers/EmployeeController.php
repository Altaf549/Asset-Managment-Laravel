<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::all();
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
}
