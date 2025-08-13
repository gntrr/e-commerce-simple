@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-orange-900">Daftar Pesanan Rempah</h1>
    <p class="mt-2 text-orange-700">Kelola semua pesanan rempah-rempah yang masuk</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-orange-200">
            <thead class="bg-orange-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Waktu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Kode
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Rempah
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Qty (gram)
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Pelanggan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Telepon
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-orange-700 uppercase tracking-wider">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-orange-200">
                @forelse($orders as $order)
                <tr class="hover:bg-orange-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-900">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-orange-900">{{ $order->code }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-orange-900">{{ $order->product_name }}</div>
                        <div class="text-sm text-orange-600">{{ $order->product_sku }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-900">
                        {{ $order->qty }} gram
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-900">
                        Rp {{ number_format($order->price * $order->qty, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-orange-900">{{ $order->customer_name }}</div>
                        <div class="text-sm text-orange-600 max-w-xs truncate">{{ $order->address }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-900">
                        {{ $order->phone }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'done') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="text-orange-400 text-4xl mb-4">🌶️</div>
                        <h3 class="text-lg font-medium text-orange-900 mb-2">Belum Ada Pesanan Rempah</h3>
                        <p class="text-orange-600">Pesanan rempah akan muncul di sini setelah ada yang memesan</p>
                    </td>
                </tr>
                @endforelse
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
@endsection