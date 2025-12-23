<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dreamy Photocard</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #A9AEE6;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 25px;
            width: 320px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .2);
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #bbb;
        }
        button {
            width: 98%;
            padding: 12px;
            background: #5865D9;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover { background: #4650b8; }
        .error-text {
            color: #e74c3c;
            font-size: 13px;
            margin-bottom: 10px;
        }
        a {
            font-size: 14px;
            color: #333;
            margin-top: 12px;
            display: inline-block;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    {{-- Menampilkan error jika email/password salah --}}
    @if ($errors->any())
        <div class="error-text">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
    
    <a href="{{ route('register') }}">Belum punya akun? Register</a>
</div>

</body>
</html>