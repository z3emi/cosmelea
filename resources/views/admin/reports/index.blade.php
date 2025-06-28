@extends('admin.layout')

@section('title', 'التقارير المالية')

@section('content')
<h1 class="h2 mb-4">ملخص الأداء المالي</h1>

<div class="row g-4">
    {{-- بطاقة الإيرادات --}}
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card shadow-sm text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">إجمالي الإيرادات</h5>
                        <p class="h3 fw-bold">{{ number_format($totalRevenue, 0) }} د.ع</p>
                    </div>
                    <i class="bi bi-cash-stack icon"></i>
                </div>
            </div>
        </div>
    </div>
    
    {{-- بطاقة تكلفة البضاعة --}}
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card shadow-sm text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">تكلفة البضاعة المباعة</h5>
                        <p class="h3 fw-bold">{{ number_format($totalCogs, 0) }} د.ع</p>
                    </div>
                    <i class="bi bi-tags icon"></i>
                </div>
            </div>
        </div>
    </div>
    
    {{-- بطاقة المصاريف --}}
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card shadow-sm text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">إجمالي المصاريف</h5>
                        <p class="h3 fw-bold">{{ number_format($totalExpenses, 0) }} د.ع</p>
                    </div>
                    <i class="bi bi-wallet2 icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- بطاقة الربح الصافي --}}
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card shadow-sm text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">الربح الصافي</h5>
                        <p class="h3 fw-bold">{{ number_format($netProfit, 0) }} د.ع</p>
                    </div>
                    <i class="bi bi-graph-up-arrow icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                ملخص الأرباح
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">إجمالي الإيرادات</dt>
                    <dd class="col-sm-9 text-success">+ {{ number_format($totalRevenue, 0) }} د.ع</dd>

                    <dt class="col-sm-3">مطروحاً منه: تكلفة البضاعة</dt>
                    <dd class="col-sm-9 text-danger">- {{ number_format($totalCogs, 0) }} د.ع</dd>

                    <dt class="col-sm-3 border-top pt-2">الربح الإجمالي</dt>
                    <dd class="col-sm-9 border-top pt-2 fw-bold">{{ number_format($grossProfit, 0) }} د.ع</dd>
                    
                    <dt class="col-sm-3">مطروحاً منه: المصاريف الأخرى</dt>
                    <dd class="col-sm-9 text-danger">- {{ number_format($totalExpenses, 0) }} د.ع</dd>

                    <dt class="col-sm-3 border-top pt-2 fs-5">الربح الصافي</dt>
                    <dd class="col-sm-9 border-top pt-2 fw-bold fs-5 text-primary">{{ number_format($netProfit, 0) }} د.ع</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
