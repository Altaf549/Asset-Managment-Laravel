<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Asset Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 30px;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background: #f5f7fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background: white;
            border-bottom: 2px solid #667eea;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .submenu {
            background: rgba(0, 0, 0, 0.2);
            padding-left: 0;
        }
        .submenu .nav-link {
            padding-left: 50px;
            font-size: 0.9em;
        }
        .form-check-input.status-toggle {
            width: 3rem;
            height: 1.5rem;
            cursor: pointer;
        }
        .form-check-input.status-toggle:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        .form-check-label {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="p-3 text-white">
            <h4><i class="fas fa-cube"></i> Asset Management</h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->is('assets/laptop/*') ? 'active' : '' }}" href="{{ route('assets.laptop.list') }}">
                <i class="fas fa-laptop"></i> Laptop
            </a>
            <div class="submenu {{ request()->is('assets/laptop/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/laptop/list') ? 'active' : '' }}" href="{{ route('assets.laptop.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/laptop/assign-history') ? 'active' : '' }}" href="{{ route('assets.laptop.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/laptop/unassign-history') ? 'active' : '' }}" href="{{ route('assets.laptop.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('assets/cpu/*') ? 'active' : '' }}" href="{{ route('assets.cpu.list') }}">
                <i class="fas fa-desktop"></i> CPU
            </a>
            <div class="submenu {{ request()->is('assets/cpu/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/cpu/list') ? 'active' : '' }}" href="{{ route('assets.cpu.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/cpu/assign-history') ? 'active' : '' }}" href="{{ route('assets.cpu.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/cpu/unassign-history') ? 'active' : '' }}" href="{{ route('assets.cpu.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('assets/mac/*') ? 'active' : '' }}" href="{{ route('assets.mac.list') }}">
                <i class="fab fa-apple"></i> Mac
            </a>
            <div class="submenu {{ request()->is('assets/mac/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/mac/list') ? 'active' : '' }}" href="{{ route('assets.mac.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/mac/assign-history') ? 'active' : '' }}" href="{{ route('assets.mac.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/mac/unassign-history') ? 'active' : '' }}" href="{{ route('assets.mac.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('assets/monitor/*') ? 'active' : '' }}" href="{{ route('assets.monitor.list') }}">
                <i class="fas fa-tv"></i> Monitor
            </a>
            <div class="submenu {{ request()->is('assets/monitor/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/monitor/list') ? 'active' : '' }}" href="{{ route('assets.monitor.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/monitor/assign-history') ? 'active' : '' }}" href="{{ route('assets.monitor.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/monitor/unassign-history') ? 'active' : '' }}" href="{{ route('assets.monitor.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('assets/keyboard/*') ? 'active' : '' }}" href="{{ route('assets.keyboard.list') }}">
                <i class="fas fa-keyboard"></i> Keyboard
            </a>
            <div class="submenu {{ request()->is('assets/keyboard/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/keyboard/list') ? 'active' : '' }}" href="{{ route('assets.keyboard.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/keyboard/assign-history') ? 'active' : '' }}" href="{{ route('assets.keyboard.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/keyboard/unassign-history') ? 'active' : '' }}" href="{{ route('assets.keyboard.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('assets/mouse/*') ? 'active' : '' }}" href="{{ route('assets.mouse.list') }}">
                <i class="fas fa-mouse"></i> Mouse
            </a>
            <div class="submenu {{ request()->is('assets/mouse/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/mouse/list') ? 'active' : '' }}" href="{{ route('assets.mouse.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/mouse/assign-history') ? 'active' : '' }}" href="{{ route('assets.mouse.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/mouse/unassign-history') ? 'active' : '' }}" href="{{ route('assets.mouse.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('assets/other/*') ? 'active' : '' }}" href="{{ route('assets.other.list') }}">
                <i class="fas fa-box"></i> Other Asset
            </a>
            <div class="submenu {{ request()->is('assets/other/*') ? '' : 'd-none' }}">
                <a class="nav-link {{ request()->is('assets/other/list') ? 'active' : '' }}" href="{{ route('assets.other.list') }}">
                    <i class="fas fa-list"></i> List
                </a>
                <a class="nav-link {{ request()->is('assets/other/assign-history') ? 'active' : '' }}" href="{{ route('assets.other.assign-history') }}">
                    <i class="fas fa-user-check"></i> Assign History
                </a>
                <a class="nav-link {{ request()->is('assets/other/unassign-history') ? 'active' : '' }}" href="{{ route('assets.other.unassign-history') }}">
                    <i class="fas fa-user-times"></i> Unassign History
                </a>
            </div>

            <a class="nav-link {{ request()->is('employees*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                <i class="fas fa-users"></i> Employees
            </a>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        $(document).ready(function() {
            // Show submenu for active parent
            $('.sidebar .nav-link.active').each(function() {
                const submenu = $(this).parent().next('.submenu');
                if (submenu.length) {
                    submenu.removeClass('d-none');
                }
            });
            
            $('.sidebar > nav > .nav-link').on('click', function(e) {
                // Don't prevent default if it's already active (to allow navigation)
                const submenu = $(this).next('.submenu');
                if (submenu.length) {
                    e.preventDefault();
                    $('.submenu').not(submenu).addClass('d-none');
                    submenu.toggleClass('d-none');
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>

