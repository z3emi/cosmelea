@extends('admin.layout')
@section('title', 'تعديل الطلب #' . $order->id)
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h4 class="mb-0">تعديل الطلب #{{ $order->id }}</h4></div>
    <div class="card-body">
         <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h5>تفاصيل العنوان</h5>
             <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">المحافظة</label>
                    <input type="text" class="form-control" name="governorate" value="{{ old('governorate', $order->governorate) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">المدينة</label>
                    <input type="text" class="form-control" name="city" value="{{ old('city', $order->city) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">أقرب نقطة دالة</label>
                    <input type="text" class="form-control" name="nearest_landmark" value="{{ old('nearest_landmark', $order->nearest_landmark) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">ملاحظات الطلب</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
            </div>
            <hr>
            <p class="text-muted">(ملاحظة: تعديل المنتجات داخل الطلب غير ممكن حالياً)</p>
            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection