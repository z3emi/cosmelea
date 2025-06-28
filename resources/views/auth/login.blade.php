@extends('layouts.auth')

@section('title', 'تسجيل الدخول')

@section('content')
    <div class="text-center mb-6">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-brand-light mb-4">
             <i class="bi bi-person text-3xl text-brand-dark"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">تسجيل الدخول</h2>
    </div>

    <!-- ** الجزء الجديد لعرض رسائل الخطأ ** -->
    @error('login')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span>{{ $message }}</span>
        </div>
    @enderror

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div>
            <label for="login" class="block text-sm font-medium text-gray-700">البريد الإلكتروني أو رقم الهاتف</label>
            <div class="mt-1">
                <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
                       class="form-input block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none sm:text-sm">
            </div>
        </div>

        <div class="mt-6">
            <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
            <div class="mt-1">
                <input id="password" name="password" type="password" required
                       class="form-input block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none sm:text-sm">
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-primary hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition">
                متابعة
            </button>
        </div>
    </form>
    <div class="text-center mt-6">
        <p class="text-sm text-gray-600">
            ليس لديك حساب؟
            <a href="{{ route('register') }}" class="font-medium text-brand-primary hover:text-brand-dark">
                سجل الآن
            </a>
        </p>
    </div>
@endsection
