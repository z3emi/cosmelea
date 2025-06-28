<?php
@extends('frontend.layout')

@section('title', 'المتجر')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">جميع المنتجات</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse ($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <a href="{{ route('product.detail', $product) }}">
                        <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name_ar }}" style="height: 250px; object-fit: cover;">
                    </a>
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title">{{ $product->name_ar }}</h5>
                        <p class="card-text fw-bold brand-text fs-5 my-2">{{ number_format($product->price, 0) }} د.ع</p>
                        {{-- فورم الإضافة إلى السلة --}}
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn brand-gradient text-white w-100">أضف إلى السلة</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">لا توجد منتجات لعرضها حالياً.</p>
            </div>
        @endforelse
    </div>
    
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection