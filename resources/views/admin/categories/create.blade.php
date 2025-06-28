@extends('admin.layout')
@section('title', 'إضافة قسم جديد')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">إنشاء قسم جديد</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error) <p class="mb-0">{{ $error }}</p> @endforeach
                </div>
            @endif
            <div class="mb-3">
                <label for="name_ar" class="form-label">اسم القسم (عربي)</label>
                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">صورة القسم</label>
                <input class="form-control" type="file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection