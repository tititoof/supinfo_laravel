<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:           #F7F5F0;
            --surface:      #FFFFFF;
            --border:       #E2DDD6;
            --text:         #1A1714;
            --muted:        #8A8278;
            --accent:       #C4622D;
            --accent-light: #F0E8E0;
            --danger:       #B0392B;
            --danger-bg:    #FAEAE8;
            --success:      #2D7A4F;
            --success-bg:   #E6F4ED;
            --radius:       12px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem;
        }

        /* Motif décoratif en fond */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(196,98,45,.06) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(196,98,45,.04) 0%, transparent 50%);
            pointer-events: none;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 32px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.04);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            animation: slideUp .3s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            padding: 2.25rem 2.25rem 0;
            text-align: center;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: var(--accent-light);
            border-radius: 14px;
            margin-bottom: 1.25rem;
        }

        .logo svg { color: var(--accent); }

        h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.7rem;
            font-weight: 400;
            letter-spacing: -.4px;
            margin-bottom: .4rem;
        }

        .subtitle {
            color: var(--muted);
            font-size: .875rem;
            margin-bottom: 0;
        }

        .card-body {
            padding: 1.75rem 2.25rem 2.25rem;
        }

        /* Alertes */
        .alert {
            padding: .8rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            font-size: .875rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: .5rem;
        }
        .alert-danger  { background: var(--danger-bg);  color: var(--danger);  border: 1px solid #f0c3be; }
        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid #b2dfc5; }

        /* Formulaire */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: .4rem;
            margin-bottom: 1.1rem;
        }

        label {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .7rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
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

        input.invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(176,57,43,.1);
        }

        .error-msg {
            font-size: .8rem;
            color: var(--danger);
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* Remember me */
        .remember {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.5rem;
            cursor: pointer;
            font-size: .875rem;
            color: var(--muted);
            user-select: none;
        }

        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        /* Bouton */
        .btn-submit {
            width: 100%;
            padding: .8rem;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, transform .1s;
            letter-spacing: .01em;
        }

        .btn-submit:hover  { background: #b0561f; }
        .btn-submit:active { transform: scale(.99); }

        /* Footer de la card */
        .card-footer {
            padding: 1.1rem 2.25rem;
            background: var(--bg);
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: .8rem;
            color: var(--muted);
        }

        .creds-list {
            display: flex;
            flex-direction: column;
            gap: .3rem;
            margin-top: .5rem;
        }

        .cred-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            font-size: .78rem;
        }

        .cred-badge {
            font-family: 'Courier New', monospace;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: .1rem .4rem;
            font-size: .75rem;
            color: var(--text);
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <div class="logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <h1>Catalogue</h1>
        <p class="subtitle">Connectez-vous pour accéder à l'application</p>
    </div>

    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0;margin-top:1px"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0;margin-top:1px"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'invalid' : '' }}"
                    placeholder="vous@example.com"
                    autocomplete="email"
                    autofocus
                >
                @error('email')
                    <span class="error-msg">
                        <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="{{ $errors->has('password') ? 'invalid' : '' }}"
                    placeholder="••••••••"
                    autocomplete="current-password"
                >
                @error('password')
                    <span class="error-msg">
                        <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <label class="remember">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Se souvenir de moi
            </label>

            <button type="submit" class="btn-submit">
                Se connecter
            </button>
        </form>
    </div>

    <div class="card-footer">
        <div>Comptes de test disponibles</div>
        <div class="creds-list">
            <div class="cred-row">
                <span class="cred-badge">admin@example.com</span>
                <span>/</span>
                <span class="cred-badge">password</span>
            </div>
            <div class="cred-row">
                <span class="cred-badge">jean.dupont@example.com</span>
                <span>/</span>
                <span class="cred-badge">password</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>