<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Услуги') - {{ config('app.name') }}</title>
    <style>
        :root {
            --bg: #f7f8fa;
            --surface: #ffffff;
            --text: #1f2328;
            --muted: #6a717d;
            --line: #e3e6ea;
            --primary: #ffcc00;
            --primary-ink: #161616;
            --accent: #2f80ed;
            --danger: #dc4d41;
            --radius: 14px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            background: linear-gradient(180deg, #fff9dd 0, var(--bg) 220px);
            color: var(--text);
            line-height: 1.45;
            font-size: 15px;
        }
        a { color: var(--accent); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .wrap { max-width: 1180px; margin: 0 auto; padding: 0 16px; }
        .topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.88);
            border-bottom: 1px solid var(--line);
        }
        .topbar-inner {
            min-height: 72px;
            display: flex;
            align-items: center;
            gap: 14px;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 8px 0;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
            text-decoration: none;
            font-weight: 800;
            letter-spacing: .2px;
        }
        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: var(--primary-ink);
            font-weight: 800;
            font-size: 18px;
        }
        .search-form { flex: 1; min-width: 260px; max-width: 560px; display: flex; gap: 8px; }
        .search-form input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 12px 14px;
            background: var(--surface);
            font-size: 15px;
        }
        .search-form input:focus { outline: none; border-color: #c8d7ea; box-shadow: 0 0 0 3px rgba(47, 128, 237, 0.15); }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid transparent;
            border-radius: 11px;
            cursor: pointer;
            padding: 10px 14px;
            font-size: 14px;
            text-decoration: none;
            transition: .15s ease;
            background: var(--surface);
            color: var(--text);
        }
        .btn:hover { text-decoration: none; }
        .btn-primary {
            background: var(--primary);
            color: var(--primary-ink);
            font-weight: 700;
            border-color: #efbf00;
        }
        .btn-primary:hover { filter: brightness(.98); }
        .btn-outline {
            border-color: var(--line);
            background: #fff;
        }
        .btn-outline:hover { border-color: #c9ced6; }

        .shell {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 18px;
            padding: 18px 0 30px;
        }
        .left-nav {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 10px;
            position: sticky;
            top: 90px;
            align-self: start;
        }
        .left-nav a {
            display: block;
            color: var(--text);
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 14px;
        }
        .left-nav a.active,
        .left-nav a:hover {
            text-decoration: none;
            background: #fff4bf;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 16px;
        }
        .with-sidebar {
            grid-template-columns: minmax(0, 1fr) 290px;
        }
        .right-side {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 16px;
        }
        .text-muted { color: var(--muted); font-size: 13px; }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 12px;
            background: #fff7d1;
            border: 1px solid #f3df8b;
            color: #5f4a00;
        }
        .alert { padding: 12px 14px; border-radius: 12px; border: 1px solid; font-size: 14px; }
        .alert-success { background: #ecf9f1; color: #17643c; border-color: #b8e3c8; }
        .alert-error { background: #fff0ef; color: #7f211a; border-color: #f6c0bc; }
        .pagination { margin-top: 16px; display: flex; gap: 8px; flex-wrap: wrap; }
        .pagination a, .pagination span {
            border: 1px solid var(--line);
            border-radius: 9px;
            padding: 7px 11px;
            background: #fff;
            font-size: 14px;
        }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; font-size: 13px; margin-bottom: 6px; color: #404753; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            background: #fff;
        }
        .form-group .error { color: var(--danger); font-size: 12px; margin-top: 4px; }

        @media (max-width: 980px) {
            .shell { grid-template-columns: 1fr; }
            .left-nav { position: static; }
            .with-sidebar { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="topbar">
        <div class="wrap topbar-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark">Y</span>
                <span>{{ config('app.name') }}</span>
            </a>
            <form action="{{ route('specialists.index') }}" method="get" class="search-form">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Какая услуга вам нужна?">
                <button type="submit" class="btn btn-primary">Найти</button>
            </form>
            <div style="display:flex; gap:8px; flex-wrap: wrap;">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline">Войти</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="btn btn-outline">{{ Auth::user()->name }}</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Админ</a>
                    @endif
                    <a href="{{ route('logout') }}" class="btn btn-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
                @endguest
            </div>
        </div>
    </header>

    <div class="wrap shell">
        <aside class="left-nav">
            <a href="{{ route('specialists.index') }}" class="{{ request()->routeIs('specialists.*') ? 'active' : '' }}">Найти специалистов</a>
            @auth
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Мои заказы</a>
                @if(Auth::user()->isSpecialist())
                    <a href="{{ route('specialist-profile.edit') }}" class="{{ request()->routeIs('specialist-profile.*') ? 'active' : '' }}">Профиль исполнителя</a>
                @else
                    <a href="{{ route('become-specialist') }}">Стать исполнителем</a>
                @endif
            @else
                <a href="{{ route('register') }}?role=specialist">Стать исполнителем</a>
            @endauth
        </aside>

        <div class="content-grid {{ trim($__env->yieldContent('sidebar')) !== '' ? 'with-sidebar' : '' }}">
            <main>
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 12px;">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error" style="margin-bottom: 12px;">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>

            @if(trim($__env->yieldContent('sidebar')) !== '')
                <aside class="right-side">
                    @yield('sidebar')
                </aside>
            @endif
        </div>
    </div>

    @stack('scripts')
</body>
</html>
