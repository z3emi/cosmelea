@extends('admin.layout')

@section('title', 'لوحة التحكم الرئيسية')

@section('content')
    <h1 class="h2 mb-4">لوحة التحكم</h1>

    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card shadow-sm" style="background-color: #3b82f6;">
                <div class="icon"><i class="bi bi-people"></i></div>
                <h5 class="card-title">إجمالي المستخدمين</h5>
                <p class="h2 fw-bold">{{ $userCount }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card shadow-sm" style="background-color: #10b981;">
                <div class="icon"><i class="bi bi-box-seam"></i></div>
                <h5 class="card-title">إجمالي المنتجات</h5>
                <p class="h2 fw-bold">{{ $productCount }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card shadow-sm" style="background-color: #8b5cf6;">
                <div class="icon"><i class="bi bi-receipt"></i></div>
                <h5 class="card-title">إجمالي الطلبات</h5>
                <p class="h2 fw-bold">{{ $orderCount }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card shadow-sm" style="background-color: #ef4444;">
                 <div class="icon"><i class="bi bi-arrow-return-left"></i></div>
                <h5 class="card-title">الطلبات الراجعة</h5>
                {{-- تحتاج إلى جلب هذه القيمة من المتحكم لاحقاً --}}
                <p class="h2 fw-bold">0</p>
            </div>
        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            ملخص الأداء الشهري
        </div>
        <div class="card-body text-center text-muted d-flex align-items-center justify-content-center" style="height: 300px;">
            <p>مخطط بياني هنا</p>
        </div>
    </div>
@endsection
