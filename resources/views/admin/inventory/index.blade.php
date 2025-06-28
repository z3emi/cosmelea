@extends('admin.layout')

@section('title', 'إدارة المخزن')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">نظرة عامة على المخزن</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية الحالية</th>
                        <th>سعر التكلفة</th>
                        <th>سعر البيع</th>
                        <th>هامش الربح للقطعة</th>
                        <th>القيمة الإجمالية للمخزون</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $totalInventoryValue = 0;
                    @endphp
                    @forelse ($products as $product)
                        @php
                            $profitMargin = $product->price - $product->cost_price;
                            $productInventoryValue = $product->cost_price * $product->stock_quantity;
                            $totalInventoryValue += $productInventoryValue;
                        @endphp
                        <tr>
                            <td class="text-end">{{ $product->name_ar }}</td>
                            <td><span class="badge bg-secondary fs-6">{{ $product->stock_quantity }}</span></td>
                            <td>{{ number_format($product->cost_price, 0) }} د.ع</td>
                            <td>{{ number_format($product->price, 0) }} د.ع</td>
                            <td>
                                <span class="badge {{ $profitMargin > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ number_format($profitMargin, 0) }} د.ع
                                </span>
                            </td>
                            <td>{{ number_format($productInventoryValue, 0) }} د.ع</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">لا توجد منتجات لعرضها.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light fw-bold fs-5">
                    <tr>
                        <td colspan="5" class="text-end">القيمة الإجمالية لكل المخزون حالياً:</td>
                        <td>{{ number_format($totalInventoryValue, 0) }} د.ع</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
