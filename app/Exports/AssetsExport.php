<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AssetsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        return Asset::where('asset_type', $this->type)
            ->with(['assignments' => function ($query) {
                $query->where('status', 'assigned')->latest()->first();
            }])
            ->get()
            ->map(function ($asset) {
                $currentAssignment = $asset->assignments()->where('status', 'assigned')->latest()->first();
                $asset->assigned_to_name = $currentAssignment ? $currentAssignment->assignedTo->name : null;
                $asset->assigned_to_id = $currentAssignment ? $currentAssignment->assigned_to : null;
                return $asset;
            });
    }

    public function headings(): array
    {
        $baseHeadings = ['ASSET ID', 'Created At', 'Updated At'];
        
        $typeHeadings = [
            'laptop' => ['Serial Number', 'Model Name', 'Manufacturer', 'Screen Size', 'RAM', 'RAM Model', 'RAM FSB', 'SSD', 'Hard Disk', 'Processor Company', 'Processor', 'Processor Generation', 'Motherboard', 'Motherboard Model'],
            'cpu' => ['Cabinet Name', 'RAM', 'RAM Model', 'RAM FSB', 'SSD', 'Hard Disk', 'Processor Company', 'Processor', 'Processor Generation', 'Motherboard', 'Motherboard Model'],
            'mac' => ['Serial Number', 'Model Name', 'Cabinet Name', 'RAM', 'RAM Model', 'RAM FSB', 'SSD', 'Hard Disk', 'Processor Company', 'Processor', 'Processor Generation', 'Motherboard', 'Motherboard Model'],
            'monitor' => ['Manufacturer', 'Screen Size', 'Resolution', 'HDMI or VGA'],
            'keyboard' => ['Manufacturer', 'Keyboard Type'],
            'mouse' => ['Manufacturer', 'Mouse Type'],
            'other' => ['Title'],
        ];
        
        $commonHeadings = ['Assigned To', 'Purchase Date', 'Vendor Name', 'Purchase Type', 'EMP ID', 'Status'];
        
        return array_merge($baseHeadings, $typeHeadings[$this->type] ?? [], $commonHeadings);
    }

    public function map($asset): array
    {
        $baseData = [
            $asset->asset_id,
            $asset->created_at ? $asset->created_at->format('Y-m-d H:i:s') : '',
            $asset->updated_at ? $asset->updated_at->format('Y-m-d H:i:s') : '',
        ];
        
        $typeData = [];
        if ($this->type === 'laptop') {
            $typeData = [
                $asset->serial_number ?? '',
                $asset->model_name ?? '',
                $asset->manufacturer ?? '',
                $asset->screen_size ?? '',
                $asset->ram ?? '',
                $asset->ram_model ?? '',
                $asset->ram_fsb ?? '',
                $asset->ssd ?? '',
                $asset->hard_disk ?? '',
                $asset->processor_company ?? '',
                $asset->processor ?? '',
                $asset->processor_generation ?? '',
                $asset->motherboard ?? '',
                $asset->motherboard_model ?? '',
            ];
        } elseif ($this->type === 'mac') {
            $typeData = [
                $asset->serial_number ?? '',
                $asset->model_name ?? '',
                $asset->cabinet_name ?? '',
                $asset->ram ?? '',
                $asset->ram_model ?? '',
                $asset->ram_fsb ?? '',
                $asset->ssd ?? '',
                $asset->hard_disk ?? '',
                $asset->processor_company ?? '',
                $asset->processor ?? '',
                $asset->processor_generation ?? '',
                $asset->motherboard ?? '',
                $asset->motherboard_model ?? '',
            ];
        } elseif ($this->type === 'cpu') {
            $typeData = [
                $asset->cabinet_name ?? '',
                $asset->ram ?? '',
                $asset->ram_model ?? '',
                $asset->ram_fsb ?? '',
                $asset->ssd ?? '',
                $asset->hard_disk ?? '',
                $asset->processor_company ?? '',
                $asset->processor ?? '',
                $asset->processor_generation ?? '',
                $asset->motherboard ?? '',
                $asset->motherboard_model ?? '',
            ];
        } elseif ($this->type === 'monitor') {
            $typeData = [
                $asset->manufacturer ?? '',
                $asset->screen_size ?? '',
                $asset->resolution ?? '',
                $asset->hdmi_or_vga ?? '',
            ];
        } elseif ($this->type === 'keyboard') {
            $typeData = [
                $asset->manufacturer ?? '',
                $asset->keyboard_type ?? '',
            ];
        } elseif ($this->type === 'mouse') {
            $typeData = [
                $asset->manufacturer ?? '',
                $asset->mouse_type ?? '',
            ];
        } elseif ($this->type === 'other') {
            $typeData = [
                $asset->title ?? '',
            ];
        }
        
        $commonData = [
            $asset->assigned_to_name ?? 'Not Assigned',
            $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : '',
            $asset->vendor_name ?? '',
            $asset->purchase_type ?? '',
            $asset->emp_id ?? '',
            $asset->status ? 'Active' : 'Inactive',
        ];
        
        return array_merge($baseData, $typeData, $commonData);
    }
}
