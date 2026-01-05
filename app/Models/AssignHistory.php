<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignHistory extends Model
{
    protected $table = 'assign_history';

    protected $fillable = [
        'asset_id',
        'assigned_to',
        'assigned_by',
        'assigned_date',
        'notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
