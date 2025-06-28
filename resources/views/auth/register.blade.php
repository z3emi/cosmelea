@extends('layouts.auth')

@section('title', 'إنشاء حساب')

@section('content')
    <div class="text-center mb-6">
         <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-brand-light mb-4">
             <i class="bi bi-person-plus text-3xl text-brand-dark"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">إنشاء حساب جديد</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        placeholder="مثال: سارة"
                        class="form-input mt-1 block w-full px-3 py-2 border rounded-md shadow-sm @error('name') is-invalid @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

<div>
    <label for="phone_number" class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
    <input id="phone_number" name="phone_number" type="tel" dir="ltr" value="{{ old('phone_number') }}" required
           pattern="^7[5-9][0-9]{8}$"
           maxlength="10" minlength="10"
           placeholder="مثال: 7701234567"
           title="أدخل رقمًا يبدأ بـ 77 , 78 , 75 , 79  (بدون الصفر وبدون +964)"
           class="form-input mt-1 block w-full px-3 py-2 border rounded-md shadow-sm @error('phone_number') is-invalid @enderror">
    @error('phone_number')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                    <input id="password" name="password" type="password" required
                           class="form-input mt-1 block w-full px-3 py-2 border rounded-md shadow-sm @error('password') is-invalid @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="form-input mt-1 block w-full px-3 py-2 border rounded-md shadow-sm">
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-primary hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition">
                إنشاء الحساب
            </button>
        </div>
    </form>
     <div class="text-center mt-6">
        <p class="text-sm text-gray-600">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}" class="font-medium text-brand-primary hover:text-brand-dark">
                سجل الدخول
            </a>
        </p>
    </div>
@endsection