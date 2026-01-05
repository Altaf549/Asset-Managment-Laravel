<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'phone',
        'department',
        'position',
        'hire_date',
        'address',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'status' => 'boolean',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'assigned_to');
    }
}
