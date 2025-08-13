@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-orange-900">🌶️ Daftar Akun</h2>
        <p class="text-orange-700 mt-2">Buat akun untuk pengalaman belanja yang lebih baik</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-orange-700 mb-2">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   required autofocus>
        </div>
        
        <div>
            <label for="email" class="block text-sm font-medium text-orange-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   required>
        </div>
        
        <div>
            <label for="phone" class="block text-sm font-medium text-orange-700 mb-2">Nomor Telepon (Opsional)</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   placeholder="08xxxxxxxxxx">
        </div>
        
        <div>
            <label for="address" class="block text-sm font-medium text-orange-700 mb-2">Alamat (Opsional)</label>
            <textarea id="address" name="address" rows="3" 
                      class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                      placeholder="Alamat lengkap untuk pengiriman">{{ old('address') }}</textarea>
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-orange-700 mb-2">Password</label>
            <input type="password" id="password" name="password" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   required>
            <p class="text-xs text-orange-600 mt-1">Minimal 8 karakter</p>
        </div>
        
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-orange-700 mb-2">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   required>
        </div>
        
        <button type="submit" 
                class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors font-medium">
            Daftar Akun
        </button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-orange-700">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-800 font-medium">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection