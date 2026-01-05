@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-user-times"></i> {{ ucfirst($type) }} Unassign History</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="unassignHistoryTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>ASSET ID</th>
                        <th>Assigned To</th>
                        <th>Assigned By</th>
                        <th>Assigned Date</th>
                        <th>Returned Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $assignment->asset->asset_id }}</td>
                        <td>{{ $assignment->assignedTo->name }} ({{ $assignment->assignedTo->employee_id }})</td>
                        <td>{{ $assignment->assignedBy ? $assignment->assignedBy->name : 'N/A' }}</td>
                        <td>{{ $assignment->assigned_date->format('Y-m-d') }}</td>
                        <td>{{ $assignment->returned_date->format('Y-m-d') }}</td>
                        <td>{{ $assignment->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#unassignHistoryTable').DataTable({
            order: [[0, 'desc']], // Sort by timestamp
            pageLength: 25
        });
    });
</script>
@endsection

