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

<div class="mb-8">
    <h1 class="text-3xl font-bold text-orange-900">Katalog Rempah-Rempah</h1>
    <p class="mt-2 text-orange-700">Temukan rempah-rempah nusantara berkualitas premium untuk dapur Anda</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach($products as $product)
    <div class="bg-white border border-orange-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="aspect-[4/3] bg-orange-100">
            <img src="{{ $product['photo'] }}" alt="{{ $product['name'] }}" 
                 class="w-full h-full object-cover" 
                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDIwMCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMTUwIiBmaWxsPSIjRkVEN0Q3Ii8+CjxwYXRoIGQ9Ik04NSA2MEg5NVY5MEg4NVY2MFoiIGZpbGw9IiNFQTU4MDYiLz4KPHA+dGggZD0iTTEwNSA2MEgxMTVWOTBIMTA1VjYwWiIgZmlsbD0iI0VBNTgwNiIvPgo8L3N2Zz4K'">
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-orange-900 mb-2">{{ $product['name'] }}</h3>
            <p class="text-sm text-orange-700 mb-3">{{ $product['desc'] }}</p>
            <div class="mb-3">
                <span class="text-lg font-bold text-orange-600">
                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                </span>
            </div>
            
            @auth
                <!-- Authenticated User Actions -->
                <div class="space-y-2">
                    <form method="POST" action="{{ route('cart.add') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="product_sku" value="{{ $product['sku'] }}">
                        <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                        <input type="hidden" name="price" value="{{ $product['price'] }}">
                        <input type="hidden" name="qty" value="100">
                        <button type="submit" 
                                class="w-full bg-orange-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-orange-700 transition-colors font-medium">
                            🛒 + Keranjang
                        </button>
                    </form>
                    <a href="/p/{{ $product['sku'] }}" 
                       class="block w-full text-center bg-orange-100 text-orange-700 px-3 py-2 rounded-lg text-sm hover:bg-orange-200 transition-colors">
                        👁️ Lihat Detail
                    </a>
                </div>
            @else
                 <!-- Guest User Actions -->
                 <div class="space-y-2">
                     <div class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-sm text-center">
                         🔒 Login untuk melihat detail
                     </div>
                     <div class="text-center">
                         <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-800 font-medium text-sm">
                             🔑 Masuk
                         </a>
                         <span class="text-orange-400 mx-2">|</span>
                         <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-800 font-medium text-sm">
                             📝 Daftar
                         </a>
                     </div>
                 </div>
             @endauth
        </div>
    </div>
    @endforeach
</div>

@if(empty($products))
<div class="text-center py-12">
    <div class="text-orange-400 text-6xl mb-4">🌶️</div>
    <h3 class="text-xl font-semibold text-orange-900 mb-2">Belum Ada Rempah</h3>
    <p class="text-orange-700">Rempah-rempah akan segera tersedia</p>
</div>
@endif
@endsection