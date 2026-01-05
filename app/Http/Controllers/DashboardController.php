<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function index()
    {
        $assetTypes = ['laptop', 'cpu', 'mac', 'monitor', 'keyboard', 'mouse', 'other'];
        $assetCounts = [];
        
        foreach ($assetTypes as $type) {
            $assetCounts[$type] = Asset::where('asset_type', $type)->count();
        }
        
        $totalAssets = array_sum($assetCounts);
        $totalEmployees = Employee::count();
        
        return view('dashboard', compact('assetCounts', 'totalAssets', 'totalEmployees'));
    }
}
