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
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="text-orange-200 hover:text-white flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15.5M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm10 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            </svg>
                            <span class="text-sm">Keranjang</span>
                            @if(auth()->user()->carts->count() > 0)
                                <span class="ml-1 bg-orange-600 text-white text-xs rounded-full px-2 py-1">{{ auth()->user()->carts->count() }}</span>
                            @endif
                        </a>
                        
                        <!-- User Menu -->
                        <div class="relative group">
                            <button class="text-orange-200 hover:text-white flex items-center text-sm">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('orders.mine') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50">
                                    📦 Riwayat Pesanan
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-orange-200 hover:text-white text-sm font-medium">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-orange-600 text-white px-3 py-1 rounded text-sm font-medium hover:bg-orange-700 transition-colors">
                                Daftar
                            </a>
                        </div>
                    @endauth
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