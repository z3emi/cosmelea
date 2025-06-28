@extends('admin.layout')

@section('title', 'إدارة الطلبات')

@php
// دالة مساعدة لإنشاء روابط الفرز التفاعلية
function sortable_link($column, $title, $currentSortBy, $currentSortDir) {
    $sortDir = ($currentSortBy == $column && $currentSortDir == 'asc') ? 'desc' : 'asc';
    $icon = '';
    if ($currentSortBy == $column) {
        $icon = $currentSortDir == 'asc' ? '<i class="bi bi-sort-up ms-1"></i>' : '<i class="bi bi-sort-down ms-1"></i>';
    }
    return '<a href="' . request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $sortDir]) . '" class="text-decoration-none text-dark">' . $title . $icon . '</a>';
}
@endphp

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="mb-0">جميع الطلبات</h4>
        <div>
            <a href="{{ route('admin.orders.trash') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i> سلة المحذوفات</a>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> إضافة طلب يدوي</a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم أو رقم الهاتف..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle" style="min-width: 900px;">
                <thead class="table-light">
                    <tr>
                        <th>{!! sortable_link('id', '#', $sortBy ?? 'id', $sortDir ?? 'desc') !!}</th>
                        <th>{!! sortable_link('user_name', 'اسم العميل', $sortBy ?? 'id', $sortDir ?? 'desc') !!}</th>
                        {{-- ** العمود الجديد لرقم الهاتف ** --}}
                        <th>رقم الهاتف</th>
                        <th>{!! sortable_link('total_amount', 'المبلغ', $sortBy ?? 'id', $sortDir ?? 'desc') !!}</th>
                        <th>{!! sortable_link('status', 'الحالة', $sortBy ?? 'id', $sortDir ?? 'desc') !!}</th>
                        <th>{!! sortable_link('created_at', 'التاريخ', $sortBy ?? 'id', $sortDir ?? 'desc') !!}</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            {{-- ** الخلية الجديدة لعرض رقم الهاتف ** --}}
                            <td>{{ $order->user->phone_number }}</td>
                            <td>{{ number_format($order->total_amount, 0) }} د.ع</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'pending') bg-warning text-dark 
                                    @elseif($order->status == 'processing') bg-info text-dark
                                    @elseif($order->status == 'shipped') bg-primary
                                    @elseif($order->status == 'delivered') bg-success
                                    @elseif($order->status == 'cancelled') bg-danger
                                    @elseif($order->status == 'returned') bg-dark
                                    @endif">
                                    {{ __('status.' . $order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary m-1 px-2" title="عرض"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-info m-1 px-2" title="تعديل"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger m-1 px-2" title="حذف"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">لا توجد طلبات لعرضها.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
