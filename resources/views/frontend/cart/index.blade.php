@extends('frontend.layout')

@section('title', 'سلة المشتريات')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">سلة المشتريات</h2>

    @if(!empty(session('cart')))
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <table class="table align-middle text-center">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>الإجمالي</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $details['image_url']) }}" class="img-fluid rounded" style="width: 80px;" alt="{{ $details['name'] }}">
                                                <span class="ms-3 fw-bold">{{ $details['name'] }}</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($details['price'], 0) }} د.ع</td>
                                        <td>
                                            {{-- فورم لتحديث الكمية --}}
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control form-control-sm text-center" style="width: 70px; margin: auto;" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td>{{ number_format($details['price'] * $details['quantity'], 0) }} د.ع</td>
                                        <td>
                                            {{-- فورم لحذف المنتج --}}
                                            <form action="{{ route('cart.destroy') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">ملخص الطلب</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>المجموع الفرعي</span>
                            <span>{{ number_format($total, 0) }} د.ع</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>رسوم التوصيل</span>
                            <span>سيتم تحديدها</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>المجموع الكلي</span>
                            <span class="brand-text">{{ number_format($total, 0) }} د.ع</span>
                        </div>
                        <div class="d-grid mt-4">
                            <a href="#" class="btn brand-gradient text-white btn-lg">إتمام عملية الشراء</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            <img src="https://i.imgur.com/dCdflKN.png" alt="سلة فارغة" class="img-fluid mb-4" style="max-width: 200px;">
            <h3>سلة المشتريات فارغة!</h3>
            <p class="text-muted">لم تقم بإضافة أي منتجات إلى السلة بعد.</p>
            <a href="{{ route('shop') }}" class="btn brand-gradient text-white mt-3">اذهب للتسوق</a>
        </div>
    @endif
</div>
@endsection
