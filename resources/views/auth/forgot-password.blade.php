<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Password - {{ config('app.name', 'SILAMO BEJANGO') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #222d32;
            /* AdminLTE Charcoal Background */
            overflow: hidden;
            position: relative;
        }

        /* Ambient Glow Background Effect */
        body::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(243, 156, 18, 0.08) 0%, transparent 40%);
            z-index: 0;
            pointer-events: none;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.05);
            /* Very subtle glass */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 50px 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            z-index: 5;
            position: relative;
        }

        .login-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .instruction-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .login-input {
            width: 100%;
            padding: 15px 20px;
            border-radius: 25px;
            border: none;
            background: white;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
            outline: none;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .login-input::placeholder {
            color: #aaa;
        }

        .forgot-link {
            display: block;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #f39c12;
        }

        .login-button {
            width: 100%;
            padding: 16px;
            border-radius: 10px;
            border: none;
            background: #f39c12;
            /* AdminLTE Orange */
            color: #222d32;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .login-button:hover {
            background: #e08e0b;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Error message styling */
        .error-msg {
            color: #dd4b39;
            font-size: 12px;
            margin-top: 5px;
            text-align: left;
            padding-left: 20px;
        }

        .success-msg {
            background: rgba(46, 204, 113, 0.2);
            border-left: 4px solid #2ecc71;
            color: #fff;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="mb-4">
            <img src="{{ asset('img/logo_silamo_bejango.png') }}" alt="Logo" class="mx-auto"
                style="height: 80px; width: auto; object-fit: contain;">
        </div>

        <div class="login-title">LUPA PASSWORD?</div>
        <div class="instruction-text">
            Jangan khawatir! Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password
            Anda.
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="success-msg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-group">
                <input type="email" name="email" class="login-input" placeholder="Alamat Email"
                    value="{{ old('email') }}" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="error-msg" />
            </div>

            <a href="{{ route('login') }}" class="forgot-link">
                Kembali ke Halaman Login
            </a>

            <button type="submit" class="login-button">
                Kirim Tautan Reset
            </button>
        </form>
    </div>
</body>

</html>
