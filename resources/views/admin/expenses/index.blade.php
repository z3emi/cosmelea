@extends('admin.layout')

@section('title', 'إدارة المصاريف')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">سجل المصاريف</h4>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>
            إضافة مصروف جديد
        </a>
    </div>
    <div class="card-body">
        {{-- فورم فلترة بالتاريخ --}}
        <form method="GET" action="{{ route('admin.expenses.index') }}" class="mb-4 p-3 bg-light border rounded">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="month" class="form-label">الشهر</label>
                    <select name="month" id="month" class="form-select">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month', date('m')) == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-5">
                     <label for="year" class="form-label">السنة</label>
                    <select name="year" id="year" class="form-select">
                        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-secondary">فلترة</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>الوصف</th>
                        <th>المبلغ</th>
                        <th>تاريخ الصرف</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalExpenses = 0; @endphp
                    @forelse ($expenses as $expense)
                        @php $totalExpenses += $expense->amount; @endphp
                        <tr>
                            <td class="text-end">{{ $expense->description }}</td>
                            <td>{{ number_format($expense->amount, 0) }} د.ع</td>
                            <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                                <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">لا توجد مصاريف مسجلة لهذا الشهر.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="1" class="text-end">إجمالي المصاريف للشهر المحدد:</td>
                        <td colspan="3">{{ number_format($totalExpenses, 0) }} د.ع</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection