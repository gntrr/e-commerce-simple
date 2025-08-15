@extends('layouts.app')

@section('content')
<!-- Flash Messages -->
@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
    <div class="flex items-center">
        <span class="text-green-500 mr-2">✅</span>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
    <div class="flex items-center">
        <span class="text-red-500 mr-2">❌</span>
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif

<div class="mb-6">
    <a href="/" class="text-orange-600 hover:text-orange-800 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Katalog Rempah
    </a>
</div>

<div class="grid md:grid-cols-2 gap-8">
    <!-- Product Image -->
    <div class="aspect-square bg-orange-100 rounded-2xl overflow-hidden border border-orange-200">
        <img src="{{ $product['photo'] }}" alt="{{ $product['name'] }}" 
             class="w-full h-full object-cover"
             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjRkVEN0Q3Ii8+CjxwYXRoIGQ9Ik0xNzAgMTYwSDE5MFYyNDBIMTcwVjE2MFoiIGZpbGw9IiNFQTU4MDYiLz4KPHA+dGggZD0iTTIxMCAxNjBIMjMwVjI0MEgyMTBWMTYwWiIgZmlsbD0iI0VBNTgwNiIvPgo8L3N2Zz4K'">
    </div>

    <!-- Product Info & Form -->
    <div>
        <h1 class="text-3xl font-bold text-orange-900 mb-4">{{ $product['name'] }}</h1>
        <p class="text-orange-700 mb-6">{{ $product['desc'] }}</p>
        
        <div class="mb-8">
            <span class="text-3xl font-bold text-orange-600">
                Rp {{ number_format($product['price'], 0, ',', '.') }}
            </span>
        </div>

        @auth
            <!-- Add to Cart Form -->
            <form method="POST" action="{{ route('cart.add') }}" class="space-y-4 mb-4">
                @csrf
                <input type="hidden" name="sku" value="{{ $product['sku'] }}">
                
                <div>
                    <label for="qty" class="block text-sm font-medium text-orange-700 mb-2">Jumlah (gram)</label>
                    <input type="number" 
                           id="qty" 
                           name="qty" 
                           min="1"
                           step="1"
                           value="1"
                           required 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <button type="submit" 
                        class="w-full bg-orange-600 text-white py-3 px-4 rounded-md hover:bg-orange-700 transition-colors font-medium">
                    🛒 Tambah ke Keranjang
                </button>
            </form>
            
            <!-- Direct Checkout Form -->
            <form method="POST" action="{{ route('checkout.direct') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="sku" value="{{ $product['sku'] }}">
                
                <div>
                    <label for="direct_qty" class="block text-sm font-medium text-orange-700 mb-2">Jumlah (gram)</label>
                    <input type="number" 
                           id="direct_qty" 
                           name="qty" 
                           min="1"
                           step="1"
                           value="1"
                           required 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <div>
                    <label for="direct_name" class="block text-sm font-medium text-orange-700 mb-2">Nama Lengkap</label>
                    <input type="text" 
                           id="direct_name" 
                           name="name" 
                           value="{{ auth()->user()->name }}"
                           required 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <div>
                    <label for="direct_phone" class="block text-sm font-medium text-orange-700 mb-2">Nomor WhatsApp</label>
                    <input type="tel" 
                           id="direct_phone" 
                           name="phone" 
                           value="{{ auth()->user()->profile->phone ?? '' }}"
                           required 
                           placeholder="08xxxxxxxxxx" 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <div>
                    <label for="direct_address" class="block text-sm font-medium text-orange-700 mb-2">Alamat Lengkap</label>
                    <textarea id="direct_address" 
                              name="address" 
                              rows="3" 
                              required 
                              class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">{{ auth()->user()->profile->address ?? '' }}</textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition-colors font-medium">
                    ⚡ Beli Langsung via WhatsApp
                </button>
            </form>
        @else
            <!-- Guest Checkout Form -->
            <form method="POST" action="{{ route('checkout') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="sku" value="{{ $product['sku'] }}">
                
                <div>
                    <label for="qty" class="block text-sm font-medium text-orange-700 mb-2">Jumlah (gram)</label>
                    <input type="number" 
                           id="qty" 
                           name="qty" 
                           min="1"
                           step="1"
                           value="1"
                           required 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-orange-700 mb-2">Nama Lengkap</label>
                    <input type="text" 
                           id="customer_name" 
                           name="name" 
                           required 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-orange-700 mb-2">Nomor WhatsApp</label>
                    <input type="tel" 
                           id="customer_phone" 
                           name="phone" 
                           required 
                           placeholder="08xxxxxxxxxx" 
                           class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <div>
                    <label for="customer_address" class="block text-sm font-medium text-orange-700 mb-2">Alamat Lengkap</label>
                    <textarea id="customer_address" 
                              name="address" 
                              rows="3" 
                              required 
                              class="w-full px-3 py-2 border border-orange-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-orange-600 text-white py-3 px-4 rounded-md hover:bg-orange-700 transition-colors font-medium">
                    🛒 Pesan Sekarang via WhatsApp
                </button>
            </form>
            
            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-700 mb-2">
                    💡 <strong>Tip:</strong> Daftar akun untuk pengalaman belanja yang lebih mudah!
                </p>
                <div class="flex space-x-2">
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Daftar Sekarang
                    </a>
                    <span class="text-blue-400">|</span>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Sudah Punya Akun?
                    </a>
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection