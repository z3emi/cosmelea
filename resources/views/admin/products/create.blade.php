@extends('admin.layout')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="card">
    <div class="card-header">
        فورم إضافة منتج جديد
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- استدعاء الفورم المشترك --}}
            @include('admin.products._form')
        </form>
    </div>
</div>
@endsection