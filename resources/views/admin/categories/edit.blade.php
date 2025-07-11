@extends('admin.layout')
@section('title', 'تعديل القسم')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">تعديل القسم: {{ $category->name_ar }}</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error) <p class="mb-0">{{ $error }}</p> @endforeach
                </div>
            @endif
            <div class="mb-3">
                <label for="name_ar" class="form-label">اسم القسم</label>
                <input type="text" class="form-control" id="name_ar" name="name_ar" value="{{ $category->name_ar }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">صورة القسم الجديدة (اتركه فارغاً لعدم التغيير)</label>
                <input class="form-control" type="file" id="image" name="image">
                <img src="{{ asset('storage/' . $category->image) }}" width="100" class="mt-2 img-thumbnail">
            </div>
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection