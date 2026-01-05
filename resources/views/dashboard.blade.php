@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
            </div>
            <div class="card-body">
                <p class="mb-0">Welcome to Asset Management System</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Total Assets Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Assets</h6>
                        <h2 class="mb-0">{{ $totalAssets }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-cube"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Employees Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Employees</h6>
                        <h2 class="mb-0">{{ $totalEmployees }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laptop Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Laptops</h6>
                        <h2 class="mb-0">{{ $assetCounts['laptop'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-laptop"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CPU Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">CPUs</h6>
                        <h2 class="mb-0">{{ $assetCounts['cpu'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-desktop"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mac Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Macs</h6>
                        <h2 class="mb-0">{{ $assetCounts['mac'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fab fa-apple"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitor Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Monitors</h6>
                        <h2 class="mb-0">{{ $assetCounts['monitor'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-tv"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyboard Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Keyboards</h6>
                        <h2 class="mb-0">{{ $assetCounts['keyboard'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="fas fa-keyboard"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mouse Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
            <div class="card-body text-white" style="color: #333 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2" style="color: #666;">Mice</h6>
                        <h2 class="mb-0" style="color: #333;">{{ $assetCounts['mouse'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50" style="color: #333;">
                        <i class="fas fa-mouse"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Assets Box -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
            <div class="card-body text-white" style="color: #333 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2" style="color: #666;">Other Assets</h6>
                        <h2 class="mb-0" style="color: #333;">{{ $assetCounts['other'] ?? 0 }}</h2>
                    </div>
                    <div class="fs-1 opacity-50" style="color: #333;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

