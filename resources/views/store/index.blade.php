@extends('layouts.app')

@section('content')
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
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-orange-600">
                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                </span>
                <a href="/p/{{ $product['sku'] }}" 
                   class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-700 transition-colors">
                    Lihat Detail
                </a>
            </div>
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