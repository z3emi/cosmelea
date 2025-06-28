@extends('admin.layout')
@section('title', 'طلبات العميل: ' . $customer->name)
@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">جميع طلبات العميل: {{ $customer->name }} ({{ $customer->phone_number }})</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>المبلغ الإجمالي</th>
                        <th>الحالة</th>
                        <th>تاريخ الطلب</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customer->orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ number_format($order->total_amount, 0) }} د.ع</td>
                            <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">لا توجد طلبات لهذا العميل.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection