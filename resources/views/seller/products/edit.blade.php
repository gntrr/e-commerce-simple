@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('seller.products.index') }}" class="text-blue-500 hover:text-blue-600 mr-4">
                ← Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('seller.products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                    <input type="text" id="sku" value="{{ $product->sku }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" 
                           disabled>
                    <p class="text-sm text-gray-500 mt-1">SKU tidak dapat diubah</p>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              required>{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="1" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                    <p class="text-sm text-gray-500 mt-1">Masukkan harga dalam rupiah</p>
                </div>

                <div class="mb-4">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">URL Foto Produk</label>
                    <input type="url" id="photo" name="photo" value="{{ old('photo', $product->photo) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="https://example.com/image.jpg">
                    <p class="text-sm text-gray-500 mt-1">Opsional. Masukkan URL gambar produk dari internet</p>
                    @if($product->photo)
                        <div class="mt-2">
                            <img src="{{ $product->photo }}" alt="{{ $product->name }}" class="h-20 w-20 object-cover rounded">
                        </div>
                    @endif
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Produk aktif (tampil di toko)</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('seller.products.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                        Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection