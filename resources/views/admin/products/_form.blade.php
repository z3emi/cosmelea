@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ** حقل تحديد القسم الجديد ** --}}
<div class="mb-3">
    <label for="category_id" class="form-label">القسم</label>
    <select class="form-select" id="category_id" name="category_id" required>
        <option value="" disabled {{ !isset($product) ? 'selected' : '' }}>-- اختر القسم --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : '' }}>
                {{ $category->name_ar }}
            </option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="name_ar" class="form-label">اسم المنتج (عربي)</label>
        <input type="text" class="form-control" id="name_ar" name="name_ar" value="{{ old('name_ar', $product->name_ar ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="name_en" class="form-label">اسم المنتج (إنجليزي)</label>
        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en', $product->name_en ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="name_ku" class="form-label">اسم المنتج (كردي)</label>
        <input type="text" class="form-control" id="name_ku" name="name_ku" value="{{ old('name_ku', $product->name_ku ?? '') }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="description_ar" class="form-label">الوصف (عربي)</label>
        <textarea class="form-control" id="description_ar" name="description_ar" rows="3" required>{{ old('description_ar', $product->description_ar ?? '') }}</textarea>
    </div>
    <div class="col-md-4 mb-3">
        <label for="description_en" class="form-label">الوصف (إنجليزي)</label>
        <textarea class="form-control" id="description_en" name="description_en" rows="3" required>{{ old('description_en', $product->description_en ?? '') }}</textarea>
    </div>
    <div class="col-md-4 mb-3">
        <label for="description_ku" class="form-label">الوصف (كردي)</label>
        <textarea class="form-control" id="description_ku" name="description_ku" rows="3" required>{{ old('description_ku', $product->description_ku ?? '') }}</textarea>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="cost_price" class="form-label">سعر التكلفة (الشراء)</label>
            <input type="number" step="any" class="form-control" id="cost_price" name="cost_price" value="{{ old('cost_price', $product->cost_price ?? '0') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="price" class="form-label">سعر البيع</label>
            <input type="number" step="any" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">الكمية في المخزون</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? '0') }}" required>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="image" class="form-label">صورة المنتج</label>
    <input class="form-control" type="file" id="image" name="image">
    @if(isset($product) && $product->image_url)
        <div class="mt-2">
            <small>الصورة الحالية:</small>
            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name_ar }}" width="100" class="img-thumbnail">
        </div>
    @endif
</div>

<button type="submit" class="btn btn-primary">حفظ</button>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">إلغاء</a>
