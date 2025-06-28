@extends('admin.layout')
@section('title', 'إدارة الأقسام')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">جميع الأقسام</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>
            إضافة قسم جديد
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>الصورة</th>
                        <th>اسم القسم</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name_ar }}" width="80" class="img-thumbnail"></td>
                            <td>{{ $category->name_ar }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3">لا توجد أقسام لعرضها.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection