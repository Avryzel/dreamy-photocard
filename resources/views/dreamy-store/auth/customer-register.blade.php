<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dreamy Photocard</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #A9AEE6;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .register-container {
            background: #fff;
            padding: 25px;
            width: 350px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .2);
            margin: 20px;
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #bbb;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #5865D9;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover { background: #4650b8; }
        .error-text {
            color: #e74c3c;
            font-size: 12px;
            text-align: left;
            padding-left: 15px;
            margin-bottom: 5px;
        }
        a {
            font-size: 14px;
            color: #333;
            margin-top: 15px;
            display: inline-block;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Daftar Akun</h2>

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
        @error('username') <div class="error-text">{{ $message }}</div> @enderror

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        @error('email') <div class="error-text">{{ $message }}</div> @enderror

        <input type="text" name="nomor_hp" placeholder="Nomor HP" value="{{ old('nomor_hp') }}" required>
        @error('nomor_hp') <div class="error-text">{{ $message }}</div> @enderror
        
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        @error('password') <div class="error-text">{{ $message }}</div> @enderror

        <button type="submit">Daftar Sekarang</button>
    </form>

    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
</div>

</body>
</html>