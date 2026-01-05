@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-users"></i> Employee List</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeModal" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Employee
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="employeesTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Hire Date</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="employeeForm">
                <div class="modal-body">
                    <input type="hidden" id="employee_id_field" name="id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="employee_id" id="employee_id" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" name="department">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="position">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hire Date</label>
                            <input type="date" class="form-control" name="hire_date">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let table;
    
    $(document).ready(function() {
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Initialize DataTable
        table = $('#employeesTable').DataTable({
            processing: true,
            ajax: {
                url: "{{ route('employees.index') }}",
                type: 'GET',
                dataSrc: 'data'
            },
            drawCallback: function() {
                // Initialize tooltips after table draw
                $('.action-btn').each(function() {
                    new bootstrap.Tooltip(this);
                });
            },
            columns: [
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function(data, type, row) {
                        if (data) {
                            const date = new Date(data);
                            return date.toLocaleString();
                        }
                        return '-';
                    }
                },
                { data: 'employee_id', name: 'employee_id', defaultContent: '-' },
                { data: 'name', name: 'name', defaultContent: '-' },
                { data: 'email', name: 'email', defaultContent: '-' },
                { data: 'phone', name: 'phone', defaultContent: '-' },
                { data: 'department', name: 'department', defaultContent: '-' },
                { data: 'position', name: 'position', defaultContent: '-' },
                { 
                    data: 'hire_date', 
                    name: 'hire_date',
                    render: function(data, type, row) {
                        return data ? data.split('T')[0] : '-';
                    }
                },
                { data: 'address', name: 'address', defaultContent: '-' },
                { 
                    data: 'status', 
                    name: 'status', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        const isActive = data ? true : false;
                        return '<div class="form-check form-switch d-inline-block">' +
                               '<input class="form-check-input status-toggle" type="checkbox" role="switch" data-id="' + row.id + '" ' + (isActive ? 'checked' : '') + '>' +
                               '</div>';
                    }
                },
                { 
                    data: 'id', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        return '<div class="d-inline-flex gap-2">' +
                               '<button class="btn btn-primary btn-sm edit-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></button>' +
                               '<button class="btn btn-danger btn-sm delete-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Delete"><i class="fas fa-trash"></i></button>' +
                               '</div>';
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 25
        });
        
        // Employee form submit
        $('#employeeForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const employeeId = $('#employee_id_field').val();
            const url = employeeId 
                ? `/api/employees/${employeeId}` 
                : '/api/employees';
            const method = employeeId ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#employeeModal').modal('hide');
                    table.ajax.reload(null, false);
                    setTimeout(function() {
                        $('.action-btn').each(function() {
                            new bootstrap.Tooltip(this);
                        });
                    }, 100);
                    alert('Employee saved successfully!');
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        let errorMsg = 'Validation errors:\n';
                        Object.keys(errors).forEach(key => {
                            errorMsg += errors[key][0] + '\n';
                        });
                        alert(errorMsg);
                    } else {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                    }
                }
            });
        });
        
        // Status toggle
        $(document).on('change', '.status-toggle', function() {
            const employeeId = $(this).data('id');
            const status = $(this).is(':checked') ? 1 : 0;
            
            $.ajax({
                url: `/api/employees/${employeeId}/toggle-status`,
                type: 'POST',
                data: { status: status },
                success: function(response) {
                    table.ajax.reload(null, false);
                    // Re-initialize tooltips after reload
                    setTimeout(function() {
                        $('.action-btn').each(function() {
                            new bootstrap.Tooltip(this);
                        });
                    }, 100);
                }
            });
        });
        
        // Edit button
        $(document).on('click', '.edit-btn', function() {
            const employeeId = $(this).data('id');
            $.ajax({
                url: `/api/employees/${employeeId}`,
                type: 'GET',
                success: function(response) {
                    fillForm(response);
                    $('#modalTitle').text('Edit Employee');
                    $('#employeeModal').modal('show');
                }
            });
        });
        
        // Delete button
        $(document).on('click', '.delete-btn', function() {
            if (confirm('Are you sure you want to delete this employee?')) {
                const employeeId = $(this).data('id');
                $.ajax({
                    url: `/api/employees/${employeeId}`,
                    type: 'DELETE',
                    success: function(response) {
                        table.ajax.reload(null, false);
                        setTimeout(function() {
                            $('.action-btn').tooltip();
                        }, 100);
                        alert('Employee deleted successfully!');
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                    }
                });
            }
        });
    });
    
    function openAddModal() {
        $('#employeeForm')[0].reset();
        $('#employee_id_field').val('');
        $('#modalTitle').text('Add Employee');
    }
    
    function fillForm(employee) {
        $('#employee_id_field').val(employee.id);
        Object.keys(employee).forEach(key => {
            const field = $(`[name="${key}"]`);
            if (field.length) {
                if (field.attr('type') === 'checkbox') {
                    field.prop('checked', employee[key] == 1);
                } else if (field.attr('type') === 'date') {
                    field.val(employee[key] ? employee[key].split('T')[0] : '');
                } else {
                    field.val(employee[key]);
                }
            }
        });
    }
</script>
@endsection

