@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-orange-900">📦 Riwayat Pesanan Saya</h1>
        <a href="{{ route('home') }}" class="text-orange-600 hover:text-orange-800 font-medium">
            ← Kembali ke Katalog
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-orange-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Rempah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Qty (gram)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-orange-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-orange-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-900">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-orange-900">{{ $order->code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-orange-900">{{ $order->product_name }}</div>
                                <div class="text-sm text-orange-500">SKU: {{ $order->product_sku }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-900">
                                {{ number_format($order->qty, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-900">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status === 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($order->status === 'done')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @endif

        <!-- Summary -->
        <div class="mt-6 bg-orange-50 rounded-lg p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-orange-900">{{ $orders->total() }}</div>
                    <div class="text-sm text-orange-700">Total Pesanan</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-900">
                        {{ $orders->where('status', 'pending')->count() }}
                    </div>
                    <div class="text-sm text-orange-700">Pending</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-900">
                        {{ $orders->where('status', 'done')->count() }}
                    </div>
                    <div class="text-sm text-orange-700">Selesai</div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <div class="text-orange-400 text-6xl mb-4">📦</div>
            <h3 class="text-xl font-semibold text-orange-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-orange-700 mb-4">Anda belum pernah melakukan pemesanan</p>
            <a href="{{ route('home') }}" 
               class="inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors font-medium">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection