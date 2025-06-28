@extends('admin.layout')
@section('title', 'سلة المحذوفات - الطلبات')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">الطلبات المحذوفة</h4>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">العودة للطلبات</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>تاريخ الحذف</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trashedOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'مستخدم محذوف' }}</td>
                            <td>{{ $order->deleted_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('admin.orders.restore', $order->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">استعادة</button>
                                </form>
                                <form action="{{ route('admin.orders.forceDelete', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟ سيتم حذف الطلب نهائياً.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف نهائي</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">سلة المحذوفات فارغة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection