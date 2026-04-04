<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indinox</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 220px;
            --font-sans: 'IBM Plex Sans', sans-serif;
            --font-mono: 'IBM Plex Mono', monospace;
        }

        body {
            font-family: var(--font-sans);
            background: #F5F5F4;
            color: #1C1917;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: #111110;
            display: flex;
            flex-direction: column;
            z-index: 50;
            border-right: 1px solid #1F1F1E;
        }

        .sidebar-logo {
            padding: 22px 20px 18px;
            border-bottom: 1px solid #1F1F1E;
        }

        .logo-mark {
            font-family: var(--font-mono);
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #E85D2F;
            display: inline-block;
            flex-shrink: 0;
        }

        .logo-sub {
            font-size: 10px;
            color: #525251;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-top: 3px;
            font-family: var(--font-mono);
        }

        /* NAV */
        .nav-section {
            padding: 16px 12px 8px;
            flex: 1;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #3D3D3C;
            padding: 0 8px;
            margin-bottom: 6px;
            margin-top: 14px;
        }

        .nav-label:first-child { margin-top: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 7px;
            color: #8A8A88;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.12s, color 0.12s;
            margin-bottom: 1px;
        }

        .nav-item:hover {
            background: #1A1A19;
            color: #E8E8E6;
        }

        .nav-item.active {
            background: #E85D2F;
            color: #fff;
        }

        .nav-item.active .nav-icon { color: #fff; }

        .nav-icon {
            width: 16px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
            color: #525251;
            transition: color 0.12s;
        }

        .nav-item:hover .nav-icon { color: #E8E8E6; }

        /* BOTTOM STATUS */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid #1F1F1E;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            color: #525251;
            font-family: var(--font-mono);
        }

        .status-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #22C55E;
            box-shadow: 0 0 6px #22C55E;
            flex-shrink: 0;
        }

        /* ── MAIN ── */
        #main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOP BAR */
        #topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(245, 245, 244, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #E7E5E4;
            padding: 0 28px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-breadcrumb {
            font-size: 13px;
            color: #78716C;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-mono);
        }

        .topbar-breadcrumb span { color: #1C1917; font-weight: 600; }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-date {
            font-family: var(--font-mono);
            font-size: 11px;
            color: #A8A29E;
            background: #F0EFEE;
            padding: 4px 10px;
            border-radius: 5px;
        }

        /* PAGE CONTENT */
        #content {
            flex: 1;
            padding: 24px 28px;
        }

        /* Flash messages */
        .flash-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #15803D;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flash-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #DC2626;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

    @php
        $currentRoute = request()->path();

        $navItems = [
            'operations' => [
                ['href' => '/dashboard', 'label' => 'Dashboard',  'icon' => '◈', 'match' => 'dashboard'],
                ['href' => '/dispatch',  'label' => 'Dispatch',   'icon' => '⇄', 'match' => 'dispatch'],
                ['href' => '/loads',     'label' => 'Loads',      'icon' => '▦', 'match' => 'loads'],
            ],
            'fleet' => [
                ['href' => '/trucks',    'label' => 'Trucks',     'icon' => '▷', 'match' => 'trucks'],
                ['href' => '/drivers',   'label' => 'Drivers',    'icon' => '◉', 'match' => 'drivers'],
            ],
            'accounts' => [
                ['href' => '/customers', 'label' => 'Customers',  'icon' => '◎', 'match' => 'customers'],
            ],
        ];

        $pageLabels = [
            'dashboard' => 'Dashboard',
            'dispatch'  => 'Dispatch',
            'loads'     => 'Loads',
            'trucks'    => 'Trucks',
            'drivers'   => 'Drivers',
            'customers' => 'Customers',
        ];

        $currentLabel = collect($pageLabels)->first(fn($label, $key) => str_starts_with($currentRoute, $key)) ?? 'Indinox';
    @endphp

    <!-- SIDEBAR -->
    <aside id="sidebar">

        <div class="sidebar-logo">
            <div class="logo-mark">
                <span class="logo-dot"></span>
                INDINOX
            </div>
            <div class="logo-sub">Logistics Engine</div>
        </div>

        <nav class="nav-section">
            @foreach($navItems as $section => $items)
                <div class="nav-label">{{ ucfirst($section) }}</div>
                @foreach($items as $item)
                    @php $isActive = str_starts_with($currentRoute, $item['match']); @endphp
                    <a href="{{ $item['href'] }}"
                       class="nav-item {{ $isActive ? 'active' : '' }}">
                        <span class="nav-icon">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            @endforeach
        </nav>

        <div class="sidebar-footer">
            <div class="status-indicator">
                <span class="status-dot"></span>
                System Online
            </div>
        </div>

    </aside>

    <!-- MAIN -->
    <div id="main">

        <!-- TOP BAR -->
        <header id="topbar">
            <div class="topbar-breadcrumb">
                indinox / <span>{{ $currentLabel }}</span>
            </div>
            <div class="topbar-right">
                <div class="topbar-date">{{ now()->format('D, d M Y') }}</div>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        @if(session('success'))
            <div style="padding: 16px 28px 0;">
                <div class="flash-success">✓ {{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div style="padding: 16px 28px 0;">
                <div class="flash-error">✕ {{ session('error') }}</div>
            </div>
        @endif

        <!-- PAGE CONTENT -->
        <main id="content">
            @yield('content')
        </main>

    </div>

</body>
</html>