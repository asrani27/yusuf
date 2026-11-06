<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SI SPT & SPPD DISKOMINFOSANTIK</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-700 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">SI SPT & SPPD</h1>
                <p class="text-sm text-gray-500 mt-1">DISKOMINFOSANTIK Kabupaten Kapuas</p>
                <p class="text-xs text-gray-400 mt-1">Sistem Informasi Surat Perintah Tugas & Perjalanan Dinas</p>
            </div>
            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-blue-600">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                    Masuk
                </button>
            </form>
        </div>
        <p class="text-center text-blue-200 text-xs mt-4">&copy; {{ date('Y') }} DISKOMINFOSANTIK Kabupaten Kapuas</p>
    </div>
</body>
</html>
