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
        <!-- Status Filter -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-center">
                <div class="d-flex align-items-center">
                    <label class="form-label me-3 mb-0 fw-bold">Filter by Status:</label>
                    <select class="form-select" name="status_filter" id="status_filter" style="width: auto;">
                        <option value="all" selected>All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        
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
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
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

<!-- Asset Details Modal -->
<div class="modal fade" id="assetDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assetDetailsModalTitle">Employee Assets</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="assetDetailsContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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
                data: function(d) {
                    d.status_filter = $('#status_filter').val();
                },
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
                               '<button class="btn btn-info btn-sm details-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Asset Details"><i class="fas fa-info-circle"></i></button>' +
                               '<button class="btn btn-primary btn-sm edit-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></button>' +
                               '<button class="btn btn-danger btn-sm delete-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Delete"><i class="fas fa-trash"></i></button>' +
                               '</div>';
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 25
        });
        
        // Handle status filter changes
        $('#status_filter').on('change', function() {
            table.ajax.reload(null, false);
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
        
        // Details button
        $(document).on('click', '.details-btn', function() {
            const employeeId = $(this).data('id');
            $('#assetDetailsContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $('#assetDetailsModal').modal('show');
            
            $.ajax({
                url: `/api/employees/${employeeId}/assets`,
                type: 'GET',
                success: function(response) {
                    displayEmployeeAssets(response);
                },
                error: function(xhr) {
                    $('#assetDetailsContent').html('<div class="alert alert-danger">Error loading employee assets</div>');
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
    
    function displayEmployeeAssets(data) {
        const employee = data.employee;
        const assets = data.assets;
        
        // Update modal title
        $('#assetDetailsModalTitle').text(`Assets assigned to ${employee.name} (${employee.employee_id})`);
        
        let html = '';
        
        if (assets.length === 0) {
            html = '<div class="alert alert-info">No assets currently assigned to this employee.</div>';
        } else {
            // Summary section
            html += '<div class="row mb-4">';
            html += '<div class="col-md-3">';
            html += '<div class="card text-center bg-primary text-white">';
            html += '<div class="card-body">';
            html += '<h5 class="card-title">' + assets.length + '</h5>';
            html += '<p class="card-text">Total Assets</p>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            // Asset types breakdown
            const assetTypes = {};
            assets.forEach(function(asset) {
                assetTypes[asset.asset_type] = (assetTypes[asset.asset_type] || 0) + 1;
            });
            
            html += '<div class="col-md-9">';
            html += '<div class="card">';
            html += '<div class="card-body">';
            html += '<h6 class="card-title">Asset Types Breakdown:</h6>';
            for (const [type, count] of Object.entries(assetTypes)) {
                html += '<span class="badge bg-secondary me-2 mb-2">' + type.charAt(0).toUpperCase() + type.slice(1) + ': ' + count + '</span>';
            }
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            // Detailed asset cards
            html += '<div class="row">';
            assets.forEach(function(asset, index) {
                html += '<div class="col-lg-6 mb-4">';
                html += '<div class="card h-100">';
                html += '<div class="card-header d-flex justify-content-between align-items-center">';
                html += '<h6 class="mb-0"><i class="fas fa-box"></i> ' + asset.asset_id + '</h6>';
                html += '<span class="badge bg-primary">' + asset.asset_type.charAt(0).toUpperCase() + asset.asset_type.slice(1) + '</span>';
                html += '</div>';
                html += '<div class="card-body">';
                
                // Basic Information
                html += '<div class="mb-3">';
                html += '<h6 class="text-primary border-bottom pb-1">Basic Information</h6>';
                html += '<div class="row">';
                html += '<div class="col-6"><strong>Asset ID:</strong> ' + asset.asset_id + '</div>';
                html += '<div class="col-6"><strong>Status:</strong> ' + (asset.status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>') + '</div>';
                html += '<div class="col-6"><strong>Assigned Date:</strong> ' + (asset.assigned_date ? new Date(asset.assigned_date).toLocaleDateString() : '-') + '</div>';
                html += '<div class="col-6"><strong>Notes:</strong> ' + (asset.notes || '-') + '</div>';
                html += '</div>';
                html += '</div>';
                
                // Asset Type Specific Details
                html += '<div class="mb-3">';
                html += '<h6 class="text-primary border-bottom pb-1">Asset Details</h6>';
                html += '<div class="row">';
                
                if (asset.asset_type === 'laptop' || asset.asset_type === 'mac') {
                    html += '<div class="col-6"><strong>Serial Number:</strong> ' + (asset.serial_number || '-') + '</div>';
                    html += '<div class="col-6"><strong>Model Name:</strong> ' + (asset.model_name || '-') + '</div>';
                    html += '<div class="col-6"><strong>Manufacturer:</strong> ' + (asset.manufacturer || '-') + '</div>';
                    if (asset.asset_type === 'laptop') {
                        html += '<div class="col-6"><strong>Screen Size:</strong> ' + (asset.screen_size || '-') + '</div>';
                    }
                    if (asset.asset_type === 'mac') {
                        html += '<div class="col-6"><strong>Cabinet Name:</strong> ' + (asset.cabinet_name || '-') + '</div>';
                    }
                } else if (asset.asset_type === 'cpu') {
                    html += '<div class="col-6"><strong>Cabinet Name:</strong> ' + (asset.cabinet_name || '-') + '</div>';
                } else if (asset.asset_type === 'monitor') {
                    html += '<div class="col-6"><strong>Manufacturer:</strong> ' + (asset.manufacturer || '-') + '</div>';
                    html += '<div class="col-6"><strong>Screen Size:</strong> ' + (asset.screen_size || '-') + '</div>';
                    html += '<div class="col-6"><strong>Resolution:</strong> ' + (asset.resolution || '-') + '</div>';
                    html += '<div class="col-6"><strong>HDMI/VGA:</strong> ' + (asset.hdmi_or_vga || '-') + '</div>';
                } else if (asset.asset_type === 'keyboard') {
                    html += '<div class="col-6"><strong>Manufacturer:</strong> ' + (asset.manufacturer || '-') + '</div>';
                    html += '<div class="col-6"><strong>Keyboard Type:</strong> ' + (asset.keyboard_type || '-') + '</div>';
                } else if (asset.asset_type === 'mouse') {
                    html += '<div class="col-6"><strong>Manufacturer:</strong> ' + (asset.manufacturer || '-') + '</div>';
                    html += '<div class="col-6"><strong>Mouse Type:</strong> ' + (asset.mouse_type || '-') + '</div>';
                } else if (asset.asset_type === 'other') {
                    html += '<div class="col-6"><strong>Title:</strong> ' + (asset.title || '-') + '</div>';
                }
                
                html += '</div>';
                html += '</div>';
                
                // Hardware Specifications (for laptop, cpu, mac)
                if (asset.asset_type === 'laptop' || asset.asset_type === 'cpu' || asset.asset_type === 'mac') {
                    html += '<div class="mb-3">';
                    html += '<h6 class="text-primary border-bottom pb-1">Hardware Specifications</h6>';
                    html += '<div class="row">';
                    html += '<div class="col-6"><strong>RAM:</strong> ' + (asset.ram || '-') + '</div>';
                    html += '<div class="col-6"><strong>RAM Model:</strong> ' + (asset.ram_model || '-') + '</div>';
                    html += '<div class="col-6"><strong>RAM FSB:</strong> ' + (asset.ram_fsb || '-') + '</div>';
                    html += '<div class="col-6"><strong>SSD:</strong> ' + (asset.ssd || '-') + '</div>';
                    html += '<div class="col-6"><strong>Hard Disk:</strong> ' + (asset.hard_disk || '-') + '</div>';
                    html += '<div class="col-6"><strong>Processor Company:</strong> ' + (asset.processor_company || '-') + '</div>';
                    html += '<div class="col-6"><strong>Processor:</strong> ' + (asset.processor || '-') + '</div>';
                    html += '<div class="col-6"><strong>Processor Generation:</strong> ' + (asset.processor_generation || '-') + '</div>';
                    html += '<div class="col-6"><strong>Motherboard:</strong> ' + (asset.motherboard || '-') + '</div>';
                    html += '<div class="col-6"><strong>Motherboard Model:</strong> ' + (asset.motherboard_model || '-') + '</div>';
                    html += '</div>';
                    html += '</div>';
                }
                
                // Purchase Information
                html += '<div class="mb-3">';
                html += '<h6 class="text-primary border-bottom pb-1">Purchase Information</h6>';
                html += '<div class="row">';
                html += '<div class="col-6"><strong>Purchase Date:</strong> ' + (asset.purchase_date ? asset.purchase_date.split('T')[0] : '-') + '</div>';
                html += '<div class="col-6"><strong>Vendor Name:</strong> ' + (asset.vendor_name || '-') + '</div>';
                html += '<div class="col-12"><strong>Purchase Type:</strong> ' + (asset.purchase_type || '-') + '</div>';
                html += '</div>';
                html += '</div>';
                
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });
            html += '</div>';
        }
        
        $('#assetDetailsContent').html(html);
    }
</script>
@endsection

