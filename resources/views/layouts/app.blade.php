<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-orange-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-orange-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-white flex items-center">
                        <span class="mr-2">🌶️</span>
                        {{ config('app.name') }}
                    </a>
                </div>
                <div class="flex items-center">
                    <span class="text-orange-200 text-sm">Rempah-rempah Nusantara Terbaik</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-orange-800 border-t mt-12">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-orange-200">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Rempah-rempah berkualitas untuk dapur Indonesia.
            </p>
        </div>
    </footer>
</body>
</html>