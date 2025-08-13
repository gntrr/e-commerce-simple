@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-orange-900">🌶️ Masuk Akun</h2>
        <p class="text-orange-700 mt-2">Masuk untuk mengakses keranjang dan riwayat pesanan</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-medium text-orange-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   required autofocus>
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-orange-700 mb-2">Password</label>
            <input type="password" id="password" name="password" 
                   class="w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   required>
        </div>
        
        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-orange-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-orange-700">Ingat saya</label>
        </div>
        
        <button type="submit" 
                class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors font-medium">
            Masuk
        </button>
    </form>
    
    <div class="mt-6 text-center">
        <p class="text-orange-700">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-800 font-medium">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection