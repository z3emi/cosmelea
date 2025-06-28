@extends('admin.layout')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">تفاصيل الطلب <span class="text-primary">#{{ $order->id }}</span></h4>
    <div>
        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-info btn-sm text-white" target="_blank">
            <i class="bi bi-printer"></i> طباعة الفاتورة
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">العودة للطلبات</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3 shadow-sm">
            <div class="card-header">المنتجات المطلوبة</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">السعر</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-end">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name_ar }}</td>
                                <td class="text-center">{{ number_format($item->price, 0) }} د.ع</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->price * $item->quantity, 0) }} د.ع</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold fs-5">
                                <td colspan="3" class="text-end">المجموع الكلي:</td>
                                <td class="text-end">{{ number_format($order->total_amount, 0) }} د.ع</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 shadow-sm">
            <div class="card-header">تفاصيل العميل</div>
            <div class="card-body">
                <p><strong>الاسم:</strong> {{ $order->user->name }}</p>
                <p><strong>رقم الهاتف:</strong> <a href="tel:{{ $order->user->phone_number }}">{{ $order->user->phone_number }}</a></p>
                <hr>
                <p><strong>عنوان التوصيل:</strong></p>
                <p class="mb-1">{{ $order->governorate }}, {{ $order->city }}</p>
                <p>{{ $order->nearest_landmark }}</p>

                @if($order->notes)
                    <hr>
                    <p><strong>ملاحظات الطلب:</strong></p>
                    <p class="text-muted">{{ $order->notes }}</p>
                @endif
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header">تحديث حالة الطلب</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <select name="status" class="form-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                        <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>راجع</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
