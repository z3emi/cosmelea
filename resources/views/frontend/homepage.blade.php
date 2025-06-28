@extends('frontend.layout')

@section('content')

<!-- Hero Slider -->
<div class="swiper main-slider h-96 md:h-[500px]">
    <div class="swiper-wrapper">
        <div class="swiper-slide bg-brand-light flex items-center justify-center">
            <div class="text-center text-brand-dark">
                <h2 class="text-4xl font-bold">عروض حصرية</h2>
                <p class="mt-2">خصومات تصل إلى 30%</p>
            </div>
        </div>
        <div class="swiper-slide bg-brand-secondary flex items-center justify-center">
             <div class="text-center text-white">
                <h2 class="text-4xl font-bold">وصل حديثاً</h2>
                <p class="mt-2">اكتشفي أحدث المنتجات</p>
            </div>
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>

<!-- Categories Section -->
<section class="py-16">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brand-dark">تسوقي حسب القسم</h2>
            <p class="text-gray-500 mt-2">ابحثي عن منتجاتك المفضلة بسهولة</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 text-center">
            @forelse($categories as $category)
            <a href="#" class="group">
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-brand-light group-hover:border-brand-primary transition shadow-md">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name_ar }}" class="w-full h-full object-cover">
                </div>
                <h3 class="mt-4 font-bold text-lg text-gray-800 group-hover:text-brand-primary">{{ $category->name_ar }}</h3>
            </a>
            @empty
            <p class="col-span-full text-center text-gray-500">سيتم إضافة الأقسام قريباً.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="bg-brand-white py-16">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brand-dark">منتجاتنا المميزة</h2>
            <p class="text-gray-500 mt-2">مختارة بعناية لتناسب جمالك</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($featuredProducts as $product)
                <div class="group relative bg-brand-white border border-brand-light rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                    <a href="{{ route('product.detail', $product) }}" class="block">
                        <div class="w-full h-64 bg-gray-200 overflow-hidden">
                            <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/400x400/f9f5f1/cd8985?text=Cosmelea' }}" 
                                 alt="{{ $product->name_ar }}" 
                                 class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    </a>
                    <div class="p-4 flex flex-col flex-grow text-center">
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('product.detail', $product) }}" class="hover:text-brand-primary">
                                    {{ $product->name_ar }}
                                </a>
                            </h3>
                        </div>
                        <p class="mt-2 text-xl font-bold text-brand-primary">{{ number_format($product->price, 0) }} د.ع</p>
                         <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-brand-dark text-white py-2 px-4 rounded-lg hover:bg-brand-primary transition-colors">أضف إلى السلة</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-4 text-center text-gray-500">لا توجد منتجات مميزة لعرضها حالياً.</p>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const swiper = new Swiper('.main-slider', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>
@endpush