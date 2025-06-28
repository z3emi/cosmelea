    @extends('admin.layout')

    @section('title', 'إدارة المستخدمين')

    @push('styles')
    <style>
        .table-row-bronze {
            background-color: #fcece0 !important;
        }
        .table-row-gold {
            background-color: #fff8e1 !important;
        }
        .table-row-banned {
            background-color: #fbe9e7 !important;
            text-decoration: line-through;
            opacity: 0.7;
        }
    </style>
    @endpush

    @section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">جميع المستخدمين</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>
                إضافة مستخدم جديد
            </a>
        </div>
        <div class="card-body">
            {{-- فورم البحث --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم أو رقم الهاتف..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>رقم الهاتف</th>
                            <th>الحالة</th>
                            <th>النوع</th>
                            <th>تاريخ التسجيل</th>
                            <th>عدد الطلبات</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            @php
                                $rowClass = '';
                                if ($user->banned_at) {
                                    $rowClass = 'table-row-banned';
                                } elseif ($user->orders_count >= 10) {
                                    $rowClass = 'table-row-gold';
                                } elseif ($user->orders_count >= 5) {
                                    $rowClass = 'table-row-bronze';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                    @if($user->banned_at)
                                        <span class="badge bg-danger">محظور</span>
                                    @else
                                        <span class="badge bg-success">نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $user->type === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $user->type === 'admin' ? 'مدير' : 'مستخدم' }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td><span class="badge bg-info">{{ $user->orders_count }}</span></td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-info">تعديل</a>
                                    {{-- ... باقي أزرار العمليات ... --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">لا يوجد مستخدمين لعرضهم.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endsection
    