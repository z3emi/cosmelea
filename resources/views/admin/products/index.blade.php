@extends('admin.layout')

@section('title', 'إدارة المنتجات')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="mb-0">جميع المنتجات</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>
            إضافة منتج جديد
        </a>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle" style="min-width: 750px;">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name_ar }}" width="60" class="img-thumbnail mx-auto">
                                @else
                                    <img src="https://placehold.co/60x60?text=No+Image" alt="No Image" class="img-thumbnail mx-auto">
                                @endif
                            </td>
                            <td>{{ $product->name_ar }}</td>
                            <td>{{ number_format($product->price, 0) }} د.ع</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary m-1">تعديل</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger m-1">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">لا توجد منتجات لعرضها.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
