<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Articles') — Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #F7F5F0;
            --surface:   #FFFFFF;
            --border:    #E2DDD6;
            --text:      #1A1714;
            --muted:     #8A8278;
            --accent:    #C4622D;
            --accent-light: #F0E8E0;
            --success:   #2D7A4F;
            --success-bg:#E6F4ED;
            --danger:    #B0392B;
            --danger-bg: #FAEAE8;
            --radius:    10px;
            --shadow:    0 2px 12px rgba(0,0,0,.07);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-size: 15px;
            line-height: 1.6;
        }

        /* NAV */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            height: 60px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-brand {
            font-family: 'DM Serif Display', serif;
            font-size: 1.3rem;
            color: var(--text);
            text-decoration: none;
            letter-spacing: -.3px;
        }
        .nav-brand span { color: var(--accent); }
        .nav-links { display: flex; align-items: center; gap: 1.5rem; }
        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            transition: color .15s;
        }
        .nav-links a:hover { color: var(--text); }
        .nav-links a.active { color: var(--accent); }

        /* User zone */
        .nav-user {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .nav-user-name {
            font-size: .85rem;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--accent-light);
            color: var(--accent);
            font-size: .75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            flex-shrink: 0;
        }
        .btn-logout {
            background: none;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: .3rem .85rem;
            font-family: inherit;
            font-size: .8rem;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: all .15s;
        }
        .btn-logout:hover { background: var(--danger-bg); color: var(--danger); border-color: #f0c3be; }

        /* LAYOUT */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .page-header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            font-weight: 400;
            letter-spacing: -.5px;
        }
        .page-header p { color: var(--muted); font-size: .9rem; margin-top: .2rem; }

        /* ALERTS */
        .alert {
            padding: .85rem 1.1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: .9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid #b2dfc5; }
        .alert-danger  { background: var(--danger-bg);  color: var(--danger);  border: 1px solid #f0c3be; }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .55rem 1.2rem;
            border-radius: var(--radius);
            font-family: inherit;
            font-size: .875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all .15s;
            white-space: nowrap;
        }
        .btn-primary  { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover  { background: #b0561f; border-color: #b0561f; }
        .btn-outline  { background: transparent; color: var(--text); border-color: var(--border); }
        .btn-outline:hover  { background: var(--bg); }
        .btn-danger   { background: transparent; color: var(--danger); border-color: #f0c3be; }
        .btn-danger:hover   { background: var(--danger-bg); }
        .btn-sm { padding: .35rem .85rem; font-size: .8rem; }

        /* CARD */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            text-align: left;
            padding: .75rem 1.1rem;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            background: var(--bg);
        }
        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--bg); }
        tbody td { padding: .9rem 1.1rem; vertical-align: middle; font-size: .9rem; }
        .td-actions { display: flex; gap: .5rem; }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: .2rem .65rem;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
        }
        .badge-green { background: var(--success-bg); color: var(--success); }
        .badge-red   { background: var(--danger-bg);  color: var(--danger); }

        /* FORM */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }
        .form-group { display: flex; flex-direction: column; gap: .4rem; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: .82rem; font-weight: 600; color: var(--text); }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: .65rem .9rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: .9rem;
            background: var(--bg);
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }
        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(196,98,45,.12);
            background: #fff;
        }
        .invalid { border-color: var(--danger) !important; }
        .error-msg { font-size: .8rem; color: var(--danger); }
        .hint { font-size: .78rem; color: var(--muted); }

        .form-actions {
            display: flex;
            gap: .75rem;
            align-items: center;
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        /* DETAIL */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
        }
        .detail-item {
            padding: 1.1rem 1.25rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }
        .detail-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); margin-bottom: .3rem; }
        .detail-value { font-size: 1.05rem; font-weight: 500; }
        .detail-value.big { font-size: 1.4rem; font-family: 'DM Serif Display', serif; color: var(--accent); }

        /* PAGINATION */
        .pagination { display: flex; gap: .4rem; margin-top: 1.5rem; justify-content: center; }
        .pagination a, .pagination span {
            padding: .4rem .8rem;
            border-radius: 6px;
            font-size: .85rem;
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--text);
            background: var(--surface);
            transition: all .15s;
        }
        .pagination a:hover { background: var(--bg); }
        .pagination .active span { background: var(--accent); color: #fff; border-color: var(--accent); }

        form.inline { display: inline; }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .nav-links { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav>
    <a class="nav-brand" href="{{ route('articles.index') }}">Cata<span>logue</span></a>

    <div class="nav-links">
        <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'active' : '' }}">Articles</a>
        <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">Panier</a>
        <a href="{{ route('receips.index') }}" class="{{ request()->routeIs('receips.*') ? 'active' : '' }}">Reçus</a>
        <a href="{{ route('cart-receip.index') }}" class="{{ request()->routeIs('cart-receip.*') ? 'active' : '' }}">Associations</a>
    </div>

    <div class="nav-user">
        @auth
            <span class="nav-user-name">
                <span class="avatar">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                {{ Auth::user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-logout">Déconnexion</button>
            </form>
        @endauth
    </div>
</nav>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>