@extends('frontend.layout')

@section('title', $product->name_ar)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="img-fluid rounded shadow" alt="{{ $product->name_ar }}">
        </div>
        <div class="col-md-6">
            <h1 class="fw-bold">{{ $product->name_ar }}</h1>
            <p class="fs-4 brand-text fw-bold my-3">{{ number_format($product->price, 0) }} د.ع</p>
            <p class="text-muted">{{ $product->description_ar }}</p>
            <hr>
            {{-- فورم الإضافة إلى السلة --}}
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex align-items-center">
                    <input type="number" name="quantity" value="1" min="1" class="form-control me-3" style="width: 80px;">
                    <button type="submit" class="btn btn-lg brand-gradient text-white">
                        <i class="bi bi-cart-plus"></i> أضف إلى السلة
                    </button>
                </div>
            </form>
            <div class="mt-3">
                <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $product->stock_quantity > 0 ? 'متوفر' : 'غير متوفر' }}
                </span>
                <span class="text-muted ms-2">(الكمية المتبقية: {{ $product->stock_quantity }})</span>
            </div>
        </div>
    </div>
</div>
@endsection