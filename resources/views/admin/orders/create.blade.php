@extends('admin.layout')

@section('title', 'إضافة طلب يدوي جديد')

@section('content')
<form action="{{ route('admin.orders.store') }}" method="POST">
    @csrf
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">إنشاء طلب جديد</h4>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error) <p class="mb-0">{{ $error }}</p> @endforeach
                </div>
            @endif

            {{-- تفاصيل العميل والطلب --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">اختر العميل</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="" disabled selected>-- اختر عميل مسجل --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->phone_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="source" class="form-label">مصدر الطلب</label>
                    <select name="source" id="source" class="form-select" required>
                        <option value="whatsapp">واتساب</option>
                        <option value="instagram">انستغرام</option>
                        <option value="phone_call">مكالمة هاتفية</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>
            </div>
            
            {{-- ========================================================= --}}
            {{-- ** هذا هو الجزء المصحح لحقول العنوان ** --}}
            {{-- ========================================================= --}}
            <h5 class="mt-3">عنوان التوصيل</h5>
            <div class="row">
                 <div class="col-md-4 mb-3">
                    <label for="governorate" class="form-label">المحافظة</label>
                    <input type="text" class="form-control" id="governorate" name="governorate" value="{{ old('governorate') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="city" class="form-label">المدينة / القضاء</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nearest_landmark" class="form-label">أقرب نقطة دالة</label>
                    <input type="text" class="form-control" id="nearest_landmark" name="nearest_landmark" value="{{ old('nearest_landmark') }}" required>
                </div>
            </div>


            <hr>

            {{-- إضافة المنتجات --}}
            <h5 class="mb-3">المنتجات المطلوبة</h5>
            <div class="row g-3 align-items-end mb-3">
                <div class="col-md-7">
                    <label for="product_selector" class="form-label">اختر منتج</label>
                    <select id="product_selector" class="form-select">
                        <option value="" selected disabled>-- اختر منتجاً لإضافته --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name_ar }}">
                                {{ $product->name_ar }} (السعر: {{ number_format($product->price, 0) }} د.ع)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="quantity_selector" class="form-label">الكمية</label>
                    <input type="number" id="quantity_selector" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="button" class="btn btn-success" id="add_product_btn">إضافة للسلة</button>
                </div>
            </div>

            {{-- جدول المنتجات المضافة --}}
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الإجمالي</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody id="order_items_table">
                    {{-- سيتم إضافة المنتجات هنا عبر الجافاسكريبت --}}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">المجموع الكلي</td>
                        <td colspan="2" id="total_amount" class="fw-bold fs-5">0 د.ع</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ الطلب</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBtn = document.getElementById('add_product_btn');
        const productSelector = document.getElementById('product_selector');
        const quantitySelector = document.getElementById('quantity_selector');
        const orderItemsTable = document.getElementById('order_items_table');
        const totalAmountCell = document.getElementById('total_amount');

        addBtn.addEventListener('click', function () {
            const selectedOption = productSelector.options[productSelector.selectedIndex];
            if (!selectedOption.value) return;

            const productId = selectedOption.value;
            const productName = selectedOption.dataset.name;
            const productPrice = parseFloat(selectedOption.dataset.price);
            const quantity = parseInt(quantitySelector.value);

            if (document.querySelector(`input[name='products[${productId}][id]']`)) {
                alert('هذا المنتج مضاف مسبقاً.');
                return;
            }

            const subtotal = productPrice * quantity;

            const newRow = `
                <tr>
                    <td>
                        <input type="hidden" name="products[${productId}][id]" value="${productId}">
                        ${productName}
                    </td>
                    <td>${productPrice.toLocaleString()} د.ع</td>
                    <td>
                        <input type="hidden" name="products[${productId}][quantity]" value="${quantity}">
                        ${quantity}
                    </td>
                    <td>${subtotal.toLocaleString()} د.ع</td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-item">حذف</button></td>
                </tr>
            `;

            orderItemsTable.insertAdjacentHTML('beforeend', newRow);
            updateTotal();
        });

        orderItemsTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('tr').remove();
                updateTotal();
            }
        });

        function updateTotal() {
            let total = 0;
            orderItemsTable.querySelectorAll('tr').forEach(row => {
                const priceText = row.children[1].textContent;
                const quantityText = row.children[2].querySelector('input').value;
                const price = parseFloat(priceText.replace(/[^0-9.-]+/g,""));
                const quantity = parseInt(quantityText);
                total += price * quantity;
            });
            totalAmountCell.textContent = total.toLocaleString() + ' د.ع';
        }
    });
</script>
@endsection
