<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة طلب #{{ $order->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }
        .brand-name {
            font-size: 2rem;
            font-weight: 700;
            color: #ec4899; /* pink-500 */
        }
        .invoice-details {
            text-align: left;
            background-color: #fde6f3; /* Lighter pink */
            padding: 20px;
            border-radius: 8px;
        }
        .invoice-details h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            color: #333;
        }
        .invoice-to {
            margin-bottom: 40px;
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .totals-section {
            display: flex;
            justify-content: flex-end;
        }
        .totals-table {
            width: 50%;
        }
        .totals-table td {
            padding: 10px 15px;
        }
        .total-row {
            background-color: #fde6f3;
            font-weight: 700;
            font-size: 1.2rem;
        }
        .signature-section {
            text-align: left;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            width: 40%;
            margin-left: auto;
        }
        .no-print {
            margin-bottom: 20px;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> طباعة الفاتورة
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">العودة للطلبات</a>
        </div>
        
        <div class="invoice-container">
            <header class="invoice-header">
                <div>
                    <h1 class="brand-name">Cosmelea</h1>
                    <div class="invoice-to">
                        <strong>فاتورة إلى:</strong><br>
                        {{ $order->user->name }}<br>
                        {{ $order->governorate }}, {{ $order->city }}<br>
                        {{ $order->nearest_landmark }}
                    </div>
                </div>
                <div class="invoice-details">
                    <h2>INVOICE</h2>
                    <p class="mb-1"><strong>رقم الفاتورة:</strong> #{{ $order->id }}</p>
                    <p class="mb-0"><strong>التاريخ:</strong> {{ $order->created_at->format('Y/m/d') }}</p>
                </div>
            </header>

            <main>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50%;">الوصف</th>
                            <th scope="col" class="text-center">السعر</th>
                            <th scope="col" class="text-center">الكمية</th>
                            <th scope="col" class="text-end">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name_ar }}</td>
                            <td class="text-center">{{ number_format($item->price, 0) }} د.ع</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price * $item->quantity, 0) }} د.ع</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="totals-section">
                    <table class="totals-table">
                        <tbody>
                            <tr>
                                <td class="text-end">المجموع الفرعي</td>
                                <td class="text-end">{{ number_format($order->total_amount, 0) }} د.ع</td>
                            </tr>
                             <tr>
                                <td class="text-end">رسوم التوصيل</td>
                                <td class="text-end">0 د.ع</td>
                            </tr>
                            <tr class="total-row">
                                <td class="text-end">المجموع الكلي</td>
                                <td class="text-end">{{ number_format($order->total_amount, 0) }} د.ع</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if($order->notes)
                <div class="mt-4">
                    <strong>ملاحظات الطلب:</strong>
                    <p class="text-muted">{{ $order->notes }}</p>
                </div>
                @endif
                
                <div class="signature-section">
                    <p>التوقيع</p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
