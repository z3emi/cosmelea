<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // استدعاء موديل المنتج
use App\Models\Category; // استدعاء موديل الأقسام
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // للتعامل مع الصور

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * عرض صفحة تحتوي على جميع المنتجات
     */
    public function index()
    {
        $products = Product::latest()->paginate(10); // جلب أحدث المنتجات مع تقسيم الصفحات
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * عرض فورم إضافة منتج جديد مع جلب الأقسام.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * تخزين المنتج الجديد مع القسم الخاص به.
     */
    public function store(Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'category_id' => 'required|exists:categories,id', // التحقق من القسم
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ku' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // صورة اختيارية
        ]);

        $data = $request->except('image');

        // التعامل مع رفع الصورة
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }

    /**
     * Display the specified resource.
     * (غير مستخدمة في هذا المثال)
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     * عرض فورم تعديل منتج موجود مع جلب الأقسام.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * تحديث المنتج مع القسم الخاص به.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id', // التحقق من القسم
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ku' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ku' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     * حذف المنتج من قاعدة البيانات
     */
    public function destroy(Product $product)
    {
        // حذف الصورة المرتبطة بالمنتج
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
