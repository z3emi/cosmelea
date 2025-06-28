    @extends('frontend.layout')

    @section('title', 'ملفي الشخصي')

    @section('content')
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- القائمة الجانبية --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4">حسابي</h3>
                        <nav class="space-y-2">
                            <a href="#personal-details" class="flex items-center px-4 py-2 text-pink-600 bg-pink-50 rounded-lg">
                                <i class="bi bi-person-circle me-3"></i>
                                <span>المعلومات الشخصية</span>
                            </a>
                            <a href="#password-security" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <i class="bi bi-lock-fill me-3"></i>
                                <span>كلمة المرور والأمان</span>
                            </a>
                             <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <i class="bi bi-box-seam-fill me-3"></i>
                                <span>طلباتي</span>
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- المحتوى الرئيسي --}}
                <div class="lg:col-span-3">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- قسم المعلومات الشخصية --}}
                    <div id="personal-details" class="bg-white p-8 rounded-lg shadow-md mb-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">المعلومات الشخصية</h2>
                        </div>
                        <form action="{{ route('profile.update.details') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="text-right mt-6">
                                <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700 transition">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>

                    {{-- قسم كلمة المرور --}}
                    <div id="password-security" class="bg-white p-8 rounded-lg shadow-md">
                         <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">كلمة المرور والأمان</h2>
                        </div>
                         <form action="{{ route('profile.update.password') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">كلمة المرور الحالية</label>
                                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                                    @error('current_password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور الجديدة</label>
                                    <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                                    @error('password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور الجديدة</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                                </div>
                            </div>
                             <div class="text-right mt-6">
                                <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700 transition">تغيير كلمة المرور</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection
    