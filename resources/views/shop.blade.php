@extends('frontend.layouts.app')
@section('title', 'المتجر')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">جميع المنتجات</h2>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    {{-- صورة المنتج --}}
                    <img src="{{ $product->image ?? asset('images/default.png') }}" class="card-img-top" alt="{{ $product->name_ar }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name_ar }}</h5>
                        <p class="card-text">{{ Str::limit($product->description_ar, 60) }}</p>
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-primary btn-sm">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection