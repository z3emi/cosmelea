@extends('frontend.layouts.app')
@section('title', 'سلة المشتريات')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">سلة المشتريات</h2>
    @if(count($cartItems) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name_ar }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->price * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('cart.destroy') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <button class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">إتمام الشراء</a>
    @else
        <div class="alert alert-info">سلة المشتريات فارغة.</div>
    @endif
</div>
@endsection