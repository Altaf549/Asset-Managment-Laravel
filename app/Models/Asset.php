<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        'asset_type',
        'asset_id',
        'serial_number',
        'model_name',
        'manufacturer',
        'cabinet_name',
        'screen_size',
        'resolution',
        'hdmi_or_vga',
        'ram',
        'ram_model',
        'ram_fsb',
        'ssd',
        'hard_disk',
        'processor_company',
        'processor',
        'processor_generation',
        'motherboard',
        'motherboard_model',
        'keyboard_type',
        'mouse_type',
        'title',
        'purchase_date',
        'vendor_name',
        'purchase_type',
        'emp_id',
        'status',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'status' => 'boolean',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class);
    }

}
