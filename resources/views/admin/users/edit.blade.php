@extends('admin.layout')

@section('title', 'تعديل المستخدم: ' . $user->name)

@section('content')
<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- بداية الأكورديون للأقسام المنسدلة --}}
    <div class="accordion" id="userEditAccordion">

        {{-- ========================================================= --}}
        {{-- القسم الأول: تعديل المعلومات الأساسية (منسدل) --}}
        {{-- ========================================================= --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    تعديل معلومات المستخدم
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#userEditAccordion">
                <div class="accordion-body">
                    {{-- عرض الأخطاء --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">نوع الحساب</label>
                            <select class="form-select" name="type" id="type">
                                <option value="user" {{ $user->type == 'user' ? 'selected' : '' }}>مستخدم</option>
                                <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>مدير</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">كلمة المرور الجديدة (اتركه فارغاً لعدم التغيير)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- القسم الثاني: الأدوار والصلاحيات (منسدل) --}}
        {{-- ========================================================= --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    الأدوار والصلاحيات
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#userEditAccordion">
                <div class="accordion-body">
                    <div class="mb-3">
                        <h6>الأدوار (Roles)</h6>
                        @forelse($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @empty
                            <p class="text-muted">لا توجد أدوار معرفة.</p>
                        @endforelse
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6>الصلاحيات المباشرة (Permissions)</h6>
                        <div class="row">
                            @forelse($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">لا توجد صلاحيات معرفة.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- نهاية الأكورديون --}}


    {{-- ========================================================= --}}
    {{-- القسم الثالث: سجل طلبات المستخدم (ظاهر دائماً) --}}
    {{-- ========================================================= --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">سجل طلبات المستخدم (آخر 5 طلبات)</h5>
            <a href="{{ route('admin.users.orders', $user->id) }}" class="btn btn-sm btn-outline-secondary">عرض كل الطلبات</a>
        </div>
        <div class="card-body">
            @if($orders->isEmpty())
                <p class="text-muted text-center">لا توجد طلبات سابقة لهذا المستخدم.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الطلب</th>
                                <th>الحالة</th>
                                <th>المبلغ</th>
                                <th>تاريخ الطلب</th>
                                <th>عرض</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
                                <td>{{ number_format($order->total_amount, 0) }} د.ع</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-xs btn-outline-secondary">التفاصيل</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>


    <div class="mt-4">
        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">العودة لقائمة المستخدمين</a>
    </div>
</form>
@endsection
