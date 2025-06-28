<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cosmelea - عالم الجمال بين يديك')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Swiper.js for slider --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    
    {{-- Alpine.js for interactive elements --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- إعداد الألوان المخصصة في Tailwind --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-bg': '#f9f5f1',
                        'brand-primary': '#cd8985',
                        'brand-dark': '#be6661',
                        'brand-light': '#eadbcd',
                        'brand-white': '#ffffff',
                        'brand-text': '#4a3f3f',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .swiper-button-next, .swiper-button-prev { color: #cd8985 !important; }
        .swiper-pagination-bullet-active { background-color: #cd8985 !important; }
    </style>
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('themes/theme-pink.css') }}">
</head>
<body class="bg-brand-bg text-brand-text" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <div id="app">
        <!-- Header -->
        <header class="bg-brand-white/95 backdrop-blur-lg shadow-sm sticky top-0 z-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Mobile Menu Button -->
                    <div class="flex-1 flex md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-brand-primary">
                            <i class="bi bi-list text-3xl"></i>
                        </button>
                    </div>

                    <!-- Logo -->
                    <div class="flex-1 flex justify-center md:justify-start">
                        <a href="{{ route('homepage') }}" class="text-4xl font-bold" style="color: #be6661;">
                            Cosmelea
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex flex-1 justify-center space-x-10 space-x-reverse">
                        <a href="{{ route('homepage') }}" class="font-semibold text-gray-700 hover:text-brand-primary transition">الرئيسية</a>
                        <a href="{{ route('shop') }}" class="font-semibold text-gray-700 hover:text-brand-primary transition">المتجر</a>
                    </nav>

                    <!-- Header Icons -->
                    <div class="flex-1 flex items-center justify-end space-x-4 space-x-reverse">
                        @guest
                            <div class="hidden sm:flex items-center space-x-2 space-x-reverse">
                                 <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-brand-primary">دخول</a>
                                <a href="{{ route('register') }}" class="bg-brand-primary text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-brand-dark transition">تسجيل جديد</a>
                            </div>
                             <a href="{{ route('login') }}" class="sm:hidden text-gray-600 hover:text-brand-primary" title="حسابي">
                                <i class="bi bi-person text-2xl"></i>
                            </a>
                        @else
                            <div class="relative" @click.outside="userMenuOpen = false">
                                <button @click="userMenuOpen = !userMenuOpen" class="text-gray-600 hover:text-brand-primary focus:outline-none" title="ملفي الشخصي">
                                    <i class="bi bi-person-check-fill text-2xl"></i>
                                </button>
                                
                                <div x-show="userMenuOpen" 
                                     x-transition
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20" style="display: none;">
                                     
                                    <div class="px-4 py-3 text-sm text-gray-700">
                                        <div>مرحباً، {{ Auth::user()->name }}</div>
                                    </div>
                                    <hr class="border-gray-200">
                                    @if(Auth::user()->type === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-dark">لوحة التحكم</a>
                                    @endif
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-dark">ملفي الشخصي</a>
                                    <hr class="border-gray-200">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                       تسجيل الخروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                               </div>
                            </div>
                        @endguest
                        <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-brand-primary" title="سلة التسوق">
                            <i class="bi bi-bag text-xl"></i>
                            @if(count((array) session('cart')) > 0)
                                <span class="absolute -top-2 -right-3 bg-brand-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ count((array) session('cart')) }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
             <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" class="md:hidden" style="display: none;">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ route('homepage') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-brand-primary hover:bg-brand-light">الرئيسية</a>
                    <a href="{{ route('shop') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-brand-primary hover:bg-brand-light">المتجر</a>
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
        
        <footer class="bg-brand-white border-t border-brand-light mt-16">
            <div class="container mx-auto px-6 py-10">
                 <div class="mt-10 border-t border-brand-light pt-6 text-center text-gray-500 text-sm">
                    <p>© {{ date('Y') }} Cosmelea. جميع الحقوق محفوظة.</p>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    @stack('scripts')

</body>
</html>