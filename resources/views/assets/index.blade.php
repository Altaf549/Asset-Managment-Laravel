@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-list"></i> {{ ucfirst($type) }} List</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('assets.' . $type . '.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assetModal" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Add {{ ucfirst($type) }}
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="assetsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ASSET ID</th>
                        <th>Name/Model</th>
                        <th>Assigned To</th>
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

<!-- Asset Modal -->
<div class="modal fade" id="assetModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add {{ ucfirst($type) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assetForm">
                <div class="modal-body">
                    <input type="hidden" id="asset_id_field" name="id">
                    <input type="hidden" name="asset_type" value="{{ $type }}">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ASSET ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="asset_id" id="asset_id" required>
                        </div>
                        
                        @if(in_array($type, ['laptop', 'mac']))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Serial Number</label>
                                <input type="text" class="form-control" name="serial_number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Model Name</label>
                                <input type="text" class="form-control" name="model_name">
                            </div>
                        @endif
                        
                        @if(in_array($type, ['laptop', 'monitor', 'keyboard', 'mouse']))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Manufacturer</label>
                                <input type="text" class="form-control" name="manufacturer">
                            </div>
                        @endif
                        
                        @if($type == 'laptop')
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Screen Size</label>
                                <input type="text" class="form-control" name="screen_size">
                            </div>
                        @endif
                        
                        @if(in_array($type, ['cpu', 'mac']))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cabinet Name</label>
                                <input type="text" class="form-control" name="cabinet_name">
                            </div>
                        @endif
                        
                        @if(in_array($type, ['laptop', 'cpu', 'mac']))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RAM</label>
                                <input type="text" class="form-control" name="ram">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RAM Model</label>
                                <input type="text" class="form-control" name="ram_model">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RAM FSB</label>
                                <input type="text" class="form-control" name="ram_fsb">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SSD</label>
                                <input type="text" class="form-control" name="ssd">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hard Disk</label>
                                <input type="text" class="form-control" name="hard_disk">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Processor Company</label>
                                <input type="text" class="form-control" name="processor_company">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Processor</label>
                                <input type="text" class="form-control" name="processor">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Processor Generation</label>
                                <input type="text" class="form-control" name="processor_generation">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Motherboard</label>
                                <input type="text" class="form-control" name="motherboard">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Motherboard Model</label>
                                <input type="text" class="form-control" name="motherboard_model">
                            </div>
                        @endif
                        
                        @if($type == 'monitor')
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Screen Size</label>
                                <input type="text" class="form-control" name="screen_size">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Resolution</label>
                                <input type="text" class="form-control" name="resolution">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">HDMI or VGA</label>
                                <select class="form-control" name="hdmi_or_vga">
                                    <option value="">Select</option>
                                    <option value="HDMI">HDMI</option>
                                    <option value="VGA">VGA</option>
                                </select>
                            </div>
                        @endif
                        
                        @if($type == 'keyboard')
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Keyboard Type</label>
                                <select class="form-control" name="keyboard_type">
                                    <option value="">Select</option>
                                    <option value="Wired">Wired</option>
                                    <option value="Bluetooth">Bluetooth</option>
                                </select>
                            </div>
                        @endif
                        
                        @if($type == 'mouse')
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mouse Type</label>
                                <select class="form-control" name="mouse_type">
                                    <option value="">Select</option>
                                    <option value="Wired">Wired</option>
                                    <option value="Bluetooth">Bluetooth</option>
                                </select>
                            </div>
                        @endif
                        
                        @if($type == 'other')
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                        @endif
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" name="purchase_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" name="vendor_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Type</label>
                            <input type="text" class="form-control" name="purchase_type">
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

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignForm">
                <div class="modal-body">
                    <input type="hidden" id="assign_asset_id" name="asset_id">
                    <div class="mb-3">
                        <label class="form-label">Assign To <span class="text-danger">*</span></label>
                        <select class="form-control" name="assigned_to" id="assigned_to" required>
                            <option value="">Select Employee</option>
                            @foreach(\App\Models\Employee::where('status', true)->get() as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="assigned_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unassign Modal -->
<div class="modal fade" id="unassignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unassign Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="unassignForm">
                <div class="modal-body">
                    <input type="hidden" id="unassign_asset_id" name="asset_id">
                    <div class="mb-3">
                        <label class="form-label">Return Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="returned_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Unassign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asset Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
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
    const assetType = '{{ $type }}';
    let table;
    
    $(document).ready(function() {
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Initialize DataTable
        table = $('#assetsTable').DataTable({
            processing: true,
            ajax: {
                url: "{{ route('assets.' . $type . '.list') }}",
                type: 'GET',
                dataSrc: 'data'
            },
            columns: getColumns(),
            order: [[0, 'asc']],
            pageLength: 25,
            drawCallback: function() {
                // Initialize tooltips after table draw
                $('.action-btn').each(function() {
                    new bootstrap.Tooltip(this);
                });
            }
        });
        
        // Initialize tooltips on page load
        $(document).ready(function() {
            $('.action-btn').each(function() {
                new bootstrap.Tooltip(this);
            });
        });
        
        // Asset form submit
        $('#assetForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const assetId = $('#asset_id_field').val();
            const url = assetId 
                ? `/api/assets/${assetId}` 
                : '/api/assets';
            const method = assetId ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    $('#assetModal').modal('hide');
                    table.ajax.reload(null, false);
                    setTimeout(function() {
                        $('.action-btn').each(function() {
                            new bootstrap.Tooltip(this);
                        });
                    }, 100);
                    alert('Asset saved successfully!');
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                }
            });
        });
        
        // Assign form submit
        $('#assignForm').on('submit', function(e) {
            e.preventDefault();
            const assetId = $('#assign_asset_id').val();
            const formData = $(this).serialize();
            
            $.ajax({
                url: `/api/assets/${assetId}/assign`,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#assignModal').modal('hide');
                    table.ajax.reload(null, false);
                    setTimeout(function() {
                        $('.action-btn').each(function() {
                            new bootstrap.Tooltip(this);
                        });
                    }, 100);
                    alert('Asset assigned successfully!');
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                }
            });
        });
        
        // Unassign form submit
        $('#unassignForm').on('submit', function(e) {
            e.preventDefault();
            const assetId = $('#unassign_asset_id').val();
            const formData = $(this).serialize();
            
            $.ajax({
                url: `/api/assets/${assetId}/unassign`,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#unassignModal').modal('hide');
                    table.ajax.reload(null, false);
                    setTimeout(function() {
                        $('.action-btn').each(function() {
                            new bootstrap.Tooltip(this);
                        });
                    }, 100);
                    alert('Asset unassigned successfully!');
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                }
            });
        });
        
        // Status toggle
        $(document).on('change', '.status-toggle', function() {
            const assetId = $(this).data('id');
            const status = $(this).is(':checked') ? 1 : 0;
            
            $.ajax({
                url: `/api/assets/${assetId}/toggle-status`,
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
            const assetId = $(this).data('id');
            $.ajax({
                url: `/api/assets/${assetId}`,
                type: 'GET',
                success: function(response) {
                    fillForm(response);
                    $('#modalTitle').text('Edit ' + assetType.charAt(0).toUpperCase() + assetType.slice(1));
                    $('#assetModal').modal('show');
                }
            });
        });
        
        // Assign button
        $(document).on('click', '.assign-btn', function() {
            const assetId = $(this).data('id');
            $('#assign_asset_id').val(assetId);
            $('#assignForm')[0].reset();
            $('#assign_asset_id').val(assetId);
            $('#assignModal').modal('show');
        });
        
        // Unassign button
        $(document).on('click', '.unassign-btn', function() {
            const assetId = $(this).data('id');
            $('#unassign_asset_id').val(assetId);
            $('#unassignForm')[0].reset();
            $('#unassign_asset_id').val(assetId);
            $('#unassignModal').modal('show');
        });
        
        // Details button
        $(document).on('click', '.details-btn', function() {
            const assetId = $(this).data('id');
            $('#detailsContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $('#detailsModal').modal('show');
            
            $.ajax({
                url: `/api/assets/${assetId}`,
                type: 'GET',
                success: function(response) {
                    displayAssetDetails(response);
                },
                error: function(xhr) {
                    $('#detailsContent').html('<div class="alert alert-danger">Error loading asset details</div>');
                }
            });
        });
    });
    
    function displayAssetDetails(asset) {
        const assetType = '{{ $type }}';
        let html = '<div class="row">';
        
        // Basic Information
        html += '<div class="col-md-6 mb-4"><h5 class="border-bottom pb-2">Basic Information</h5>';
        html += '<table class="table table-sm">';
        html += '<tr><th width="40%">ASSET ID:</th><td>' + (asset.asset_id || '-') + '</td></tr>';
        html += '<tr><th>Created At:</th><td>' + (asset.created_at ? new Date(asset.created_at).toLocaleString() : '-') + '</td></tr>';
        html += '<tr><th>Updated At:</th><td>' + (asset.updated_at ? new Date(asset.updated_at).toLocaleString() : '-') + '</td></tr>';
        html += '</table></div>';
        
        // Asset Type Specific Fields
        html += '<div class="col-md-6 mb-4"><h5 class="border-bottom pb-2">Asset Details</h5>';
        html += '<table class="table table-sm">';
        
        if (assetType === 'laptop' || assetType === 'mac') {
            html += '<tr><th width="40%">Serial Number:</th><td>' + (asset.serial_number || '-') + '</td></tr>';
            html += '<tr><th>Model Name:</th><td>' + (asset.model_name || '-') + '</td></tr>';
            html += '<tr><th>Manufacturer:</th><td>' + (asset.manufacturer || '-') + '</td></tr>';
            if (assetType === 'laptop') {
                html += '<tr><th>Screen Size:</th><td>' + (asset.screen_size || '-') + '</td></tr>';
            }
            if (assetType === 'mac') {
                html += '<tr><th>Cabinet Name:</th><td>' + (asset.cabinet_name || '-') + '</td></tr>';
            }
        } else if (assetType === 'cpu') {
            html += '<tr><th width="40%">Cabinet Name:</th><td>' + (asset.cabinet_name || '-') + '</td></tr>';
        } else if (assetType === 'monitor') {
            html += '<tr><th width="40%">Manufacturer:</th><td>' + (asset.manufacturer || '-') + '</td></tr>';
            html += '<tr><th>Screen Size:</th><td>' + (asset.screen_size || '-') + '</td></tr>';
            html += '<tr><th>Resolution:</th><td>' + (asset.resolution || '-') + '</td></tr>';
            html += '<tr><th>HDMI or VGA:</th><td>' + (asset.hdmi_or_vga || '-') + '</td></tr>';
        } else if (assetType === 'keyboard') {
            html += '<tr><th width="40%">Manufacturer:</th><td>' + (asset.manufacturer || '-') + '</td></tr>';
            html += '<tr><th>Keyboard Type:</th><td>' + (asset.keyboard_type || '-') + '</td></tr>';
        } else if (assetType === 'mouse') {
            html += '<tr><th width="40%">Manufacturer:</th><td>' + (asset.manufacturer || '-') + '</td></tr>';
            html += '<tr><th>Mouse Type:</th><td>' + (asset.mouse_type || '-') + '</td></tr>';
        } else if (assetType === 'other') {
            html += '<tr><th width="40%">Title:</th><td>' + (asset.title || '-') + '</td></tr>';
        }
        
        html += '</table></div>';
        
        // Hardware Specifications (for laptop, cpu, mac)
        if (assetType === 'laptop' || assetType === 'cpu' || assetType === 'mac') {
            html += '<div class="col-md-12 mb-4"><h5 class="border-bottom pb-2">Hardware Specifications</h5>';
            html += '<div class="row">';
            html += '<div class="col-md-6"><table class="table table-sm">';
            html += '<tr><th width="40%">RAM:</th><td>' + (asset.ram || '-') + '</td></tr>';
            html += '<tr><th>RAM Model:</th><td>' + (asset.ram_model || '-') + '</td></tr>';
            html += '<tr><th>RAM FSB:</th><td>' + (asset.ram_fsb || '-') + '</td></tr>';
            html += '<tr><th>SSD:</th><td>' + (asset.ssd || '-') + '</td></tr>';
            html += '<tr><th>Hard Disk:</th><td>' + (asset.hard_disk || '-') + '</td></tr>';
            html += '</table></div>';
            html += '<div class="col-md-6"><table class="table table-sm">';
            html += '<tr><th width="40%">Processor Company:</th><td>' + (asset.processor_company || '-') + '</td></tr>';
            html += '<tr><th>Processor:</th><td>' + (asset.processor || '-') + '</td></tr>';
            html += '<tr><th>Processor Generation:</th><td>' + (asset.processor_generation || '-') + '</td></tr>';
            html += '<tr><th>Motherboard:</th><td>' + (asset.motherboard || '-') + '</td></tr>';
            html += '<tr><th>Motherboard Model:</th><td>' + (asset.motherboard_model || '-') + '</td></tr>';
            html += '</table></div></div></div>';
        }
        
        // Purchase Information
        html += '<div class="col-md-6 mb-4"><h5 class="border-bottom pb-2">Purchase Information</h5>';
        html += '<table class="table table-sm">';
        html += '<tr><th width="40%">Purchase Date:</th><td>' + (asset.purchase_date ? asset.purchase_date.split('T')[0] : '-') + '</td></tr>';
        html += '<tr><th>Vendor Name:</th><td>' + (asset.vendor_name || '-') + '</td></tr>';
        html += '<tr><th>Purchase Type:</th><td>' + (asset.purchase_type || '-') + '</td></tr>';
        html += '</table></div>';
        
        // Status
        html += '<div class="col-md-6 mb-4"><h5 class="border-bottom pb-2">Status</h5>';
        html += '<table class="table table-sm">';
        html += '<tr><th width="40%">Status:</th><td>';
        html += asset.status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
        html += '</td></tr>';
        html += '</table></div>';
        
        html += '</div>';
        $('#detailsContent').html(html);
    }
    
    function openAddModal() {
        $('#assetForm')[0].reset();
        $('#asset_id_field').val('');
        $('#modalTitle').text('Add ' + assetType.charAt(0).toUpperCase() + assetType.slice(1));
    }
    
    function fillForm(asset) {
        $('#asset_id_field').val(asset.id);
        Object.keys(asset).forEach(key => {
            const field = $(`[name="${key}"]`);
            if (field.length) {
                if (field.attr('type') === 'checkbox') {
                    field.prop('checked', asset[key] == 1);
                } else if (field.attr('type') === 'date') {
                    field.val(asset[key] ? asset[key].split('T')[0] : '');
                } else {
                    field.val(asset[key]);
                }
            }
        });
    }
    
    function getColumns() {
        // Get name/model based on asset type
        function getNameModel(data, type, row) {
            if (assetType === 'laptop' || assetType === 'mac') {
                return row.model_name || row.serial_number || row.asset_id || '-';
            } else if (assetType === 'cpu') {
                return row.cabinet_name || row.asset_id || '-';
            } else if (assetType === 'monitor' || assetType === 'keyboard' || assetType === 'mouse') {
                return row.manufacturer || row.asset_id || '-';
            } else if (assetType === 'other') {
                return row.title || row.asset_id || '-';
            }
            return row.asset_id || '-';
        }
        
        return [
            { data: 'asset_id', name: 'asset_id', defaultContent: '-' },
            { 
                data: 'asset_id', 
                name: 'name_model',
                render: function(data, type, row) {
                    return getNameModel(data, type, row);
                }
            },
            { 
                data: 'assigned_to_name', 
                name: 'assigned_to',
                render: function(data, type, row) {
                    return data || '-';
                }
            },
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
                    const isAssigned = row.assigned_to_id !== null;
                    const assignBtn = isAssigned 
                        ? '<button class="btn btn-warning btn-sm unassign-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Unassign"><i class="fas fa-user-minus"></i></button>'
                        : '<button class="btn btn-info btn-sm assign-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Assign"><i class="fas fa-user-plus"></i></button>';
                    return '<div class="d-inline-flex gap-2">' +
                           '<button class="btn btn-success btn-sm details-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Details"><i class="fas fa-info-circle"></i></button>' +
                           '<button class="btn btn-primary btn-sm edit-btn action-btn" data-id="' + row.id + '" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fas fa-edit"></i></button>' +
                           assignBtn +
                           '</div>';
                }
            }
        ];
    }
</script>
@endsection

