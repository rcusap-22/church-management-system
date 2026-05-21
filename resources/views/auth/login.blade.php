<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Church Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --maroon: #6b0f1a;
            --maroon-dark: #4a0a12;
            --gold: #c9a84c;
            --gold-light: #e2c97e;
            --cream: #fdf8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .auth-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border-top: 4px solid var(--gold);
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .auth-logo .icon { font-size: 2.5rem; }
        .auth-logo h1 {
            color: var(--maroon);
            font-size: 1.4rem;
            font-weight: 800;
            margin-top: 0.5rem;
        }
        .auth-logo p {
            color: #888;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        .form-group { margin-bottom: 1.1rem; }
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--maroon);
            margin-bottom: 0.4rem;
            font-size: 0.88rem;
        }
        .form-control {
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 0.92rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
        }
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, var(--maroon), #8b1a2a);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: opacity 0.2s;
        }
        .btn-submit:hover { opacity: 0.9; }
        .auth-footer {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.88rem;
            color: #888;
        }
        .auth-footer a { color: var(--maroon); font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        .error-msg { color: red; font-size: 0.8rem; margin-top: 0.25rem; }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            font-size: 0.88rem;
        }
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .remember-row label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.88rem;
            color: #555;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon">✝️</div>
            <h1>Church Management</h1>
            <p>Sign in to your account</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email') }}" placeholder="you@email.com" required autofocus>
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="••••••••" required>
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:0.85rem; color:var(--maroon);">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-submit"> Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account?
            <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</body>
</html>