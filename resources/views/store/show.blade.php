@extends('layouts.app')

@section('content')
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

        <!-- Checkout Form -->
        <form action="/checkout" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="sku" value="{{ $product['sku'] }}">
            
            <div>
                <label for="qty" class="block text-sm font-medium text-orange-700 mb-2">Jumlah (gram)</label>
                <input type="number" id="qty" name="qty" value="100" min="50" step="50" 
                       class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                @error('qty')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="name" class="block text-sm font-medium text-orange-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-orange-700 mb-2">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                       class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="address" class="block text-sm font-medium text-orange-700 mb-2">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3" 
                          class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" 
                    class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                </svg>
                Beli via WhatsApp
            </button>
        </form>
    </div>
</div>
@endsection