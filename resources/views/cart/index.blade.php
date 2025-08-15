@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
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

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-orange-900">🛒 Keranjang Belanja</h1>
        <a href="{{ route('home') }}" class="text-orange-600 hover:text-orange-800 font-medium">
            ← Lanjut Belanja
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($carts->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-orange-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Qty (gram)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-orange-200">
                        @foreach($carts as $cart)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-orange-900">{{ $cart->product_name }}</div>
                                <div class="text-sm text-orange-500">SKU: {{ $cart->product_sku }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-900">
                                Rp {{ number_format($cart->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('cart.update', $cart) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="qty" value="{{ $cart->qty }}" min="1"
                                           class="w-20 px-2 py-1 border border-orange-300 rounded text-sm focus:ring-1 focus:ring-orange-500">
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-900">
                                Rp {{ number_format($cart->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('cart.remove', $cart) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium"
                                            onclick="return confirm('Hapus produk dari keranjang?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Cart Summary -->
            <div class="bg-orange-50 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-4">
                        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                    onclick="return confirm('Kosongkan seluruh keranjang?')">
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-orange-900">
                            Total: Rp {{ number_format($total, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-orange-700">{{ $carts->count() }} item dalam keranjang</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-orange-900 mb-4">Informasi Pengiriman</h3>
            
            <form action="{{ route('checkout') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="from_cart" value="1">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-orange-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" 
                               value="{{ auth()->user()->name }}" 
                               class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                               required>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-orange-700 mb-2">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" 
                               value="{{ auth()->user()->profile->phone ?? '' }}" 
                               class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                               required>
                    </div>
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-orange-700 mb-2">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" 
                              class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                              required>{{ auth()->user()->profile->address ?? '' }}</textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-orange-600 text-white py-3 px-4 rounded-lg hover:bg-orange-700 transition-colors font-medium flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    Checkout via WhatsApp
                </button>
            </form>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <div class="text-orange-400 text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-semibold text-orange-900 mb-2">Keranjang Kosong</h3>
            <p class="text-orange-700 mb-4">Belum ada rempah-rempah dalam keranjang Anda</p>
            <a href="{{ route('home') }}" 
               class="inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors font-medium">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection