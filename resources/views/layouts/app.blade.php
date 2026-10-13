
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | StyleHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        :root {
            --purple: #7652d6;
            --purple-dark: #5232a5;
            --purple-light: #f2edff;
            --ink: #28233a;
            --muted: #777387;
            --page: #f8f7fc;
        }

        body {
            background: var(--page);
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, sans-serif;
        }

        .sidebar {
            background: #fff;
            border-right: 1px solid #ece8f5;
            min-height: 100vh;
        }

        .brand {
            color: var(--purple-dark);
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .nav-link {
            color: #666078;
            border-radius: 12px;
            margin-bottom: 6px;
            padding: 12px 14px;
            transition: .2s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--purple-light);
            color: var(--purple-dark);
            transform: translateX(3px);
        }

        .main-content { padding: 28px; }

        .panel, .stat-card {
            background: #fff;
            border: 1px solid #eeeaf6;
            border-radius: 18px;
            box-shadow: 0 6px 24px rgba(48, 28, 90, .04);
        }

        .panel { padding: 22px; }
        .stat-card { padding: 22px; transition: .2s ease; }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(83, 51, 151, .10);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            background: var(--purple-light);
            color: var(--purple);
            border-radius: 14px;
            font-size: 1.3rem;
        }

        .btn-primary {
            background: var(--purple);
            border-color: var(--purple);
        }

        .btn-primary:hover {
            background: var(--purple-dark);
            border-color: var(--purple-dark);
        }

        .form-control, .form-select {
            border-color: #e6e1ef;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 .2rem rgba(118, 82, 214, .12);
        }

        .table th {
            color: var(--muted);
            font-size: .82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .table td, .table th { padding: 14px 12px; vertical-align: middle; }
        .page-title { font-weight: 800; letter-spacing: -.5px; }
        .muted { color: var(--muted); }

        @media (max-width: 767px) {
            .sidebar { min-height: auto; }
            .main-content { padding: 16px; }
            .nav.flex-column { flex-direction: row !important; flex-wrap: wrap; }
            .nav-link { padding: 8px 10px; }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <a href="{{ route('dashboard') }}"
               class="brand text-decoration-none d-block mb-4">
                <i class="bi bi-bag-heart-fill me-2"></i>StyleHub
            </a>

            <div class="small text-uppercase muted fw-bold mb-2">Workspace</div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-grid me-2"></i>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                   href="{{ route('categories.index') }}">
                    <i class="bi bi-tags me-2"></i>Categories
                </a>
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                   href="{{ route('products.index') }}">
                    <i class="bi bi-bag me-2"></i>Products
                </a>
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                   href="{{ route('customers.index') }}">
                    <i class="bi bi-people me-2"></i>Customers
                </a>
                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                   href="{{ route('orders.index') }}">
                    <i class="bi bi-receipt me-2"></i>Orders
                </a>
            </nav>

            <div class="small muted mt-4">
                <i class="bi bi-shop me-1"></i> Clothing Store Management
            </div>
        </aside>

        <main class="col-md-9 col-lg-10 main-content">
            <header class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <div class="muted small">STYLEHUB MANAGEMENT</div>
                    <h1 class="h3 page-title mb-0">@yield('heading', 'Dashboard')</h1>
                </div>
                <span class="badge rounded-pill text-bg-light border p-2">
                    <i class="bi bi-stars me-1"></i>Store Admin
                </span>
            </header>

            @include('partials.alerts')

            @yield('content')

            <footer class="text-center muted small mt-5 mb-3">
                StyleHub · Laravel Clothing Store Management
            </footer>
        </main>
    </div>
</div>
</body>
</html>