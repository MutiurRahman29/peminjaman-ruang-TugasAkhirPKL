<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Peminjaman Ruang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="h-screen w-full flex flex-col justify-center items-center">
    <div class="-mt-20 h-xl p-4 border-2 rounded-lg shadow-lg">
        <h1 class="text-3xl m-4 flex justify-center">Masuk</h1>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div>
                <label for="username">Username</label>
                <br>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus
                    autocomplete="username" class="@error('username') border-red-500 @enderror border-2">
                @error('username')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div class="">
                <label for="password">Password</label>
                <br>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="@error('password') border-red-500 @enderror border-2">
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="remember">
                    <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="w-full flex justify-center items-center mt-3 bg-blue-600 p-1 rounded border">Masuk</button>
        </form>
    </div>
</body>

</html>
