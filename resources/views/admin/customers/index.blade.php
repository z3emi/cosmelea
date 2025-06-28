@extends('admin.layout')
@section('title', 'إدارة العملاء')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="mb-0">جميع العملاء</h4>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> إضافة عميل يدوي
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle" style="min-width: 800px;">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>رقم الهاتف</th>
                        <th>عدد الطلبات</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->orders_count }}</td>
                            <td>
                                @if ($customer->orders_count >= 10)
                                    <span class="badge" style="background-color: #ffd700; color: #4a3f3f;">ذهبي</span>
                                @elseif ($customer->orders_count >= 5)
                                    <span class="badge" style="background-color: #cd7f32; color: white;">برونزي</span>
                                @else
                                    <span class="badge bg-secondary">جديد</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-primary m-1 px-2" title="عرض الطلبات"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-info m-1 px-2" title="تعديل"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">لا يوجد عملاء لعرضهم.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $customers->links() }}</div>
    </div>
</div>
@endsection