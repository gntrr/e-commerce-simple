@extends('layouts.app')

@section('content')
<!-- Flash Messages -->
@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
    <div class="flex items-center">
        <span class="text-green-500 mr-2">✅ </span>
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
                    <button type="button" 
                            onclick="openQuantityModal('{{ $product['sku'] }}', '{{ $product['name'] }}', {{ $product['price'] }})"
                            class="w-full bg-orange-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-orange-700 transition-colors font-medium">
                        🛒 + Keranjang
                    </button>
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

<!-- Quantity Modal -->
<div id="quantityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96 mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-orange-900">Tambah ke Keranjang</h3>
            <button onclick="closeQuantityModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-2">Produk: <span id="modalProductName" class="font-medium"></span></p>
            <p class="text-sm text-gray-600 mb-4">Harga: <span id="modalProductPrice" class="font-medium text-orange-600"></span></p>
        </div>
        
        <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" id="modalProductSku" name="product_sku">
            <input type="hidden" id="modalProductNameInput" name="product_name">
            <input type="hidden" id="modalProductPriceInput" name="price">
            
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Kuantitas (gram)</label>
                <input type="number" 
                       id="quantity" 
                       name="qty" 
                       min="1" 
                       value="50" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="closeQuantityModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    Tambah ke Keranjang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openQuantityModal(sku, name, price) {
    document.getElementById('modalProductSku').value = sku;
    document.getElementById('modalProductNameInput').value = name;
    document.getElementById('modalProductPriceInput').value = price;
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('quantityModal').classList.remove('hidden');
    document.getElementById('quantity').focus();
}

function closeQuantityModal() {
    document.getElementById('quantityModal').classList.add('hidden');
    document.getElementById('quantity').value = '50';
}

// Close modal when clicking outside
document.getElementById('quantityModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuantityModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeQuantityModal();
    }
});
</script>

@endsection