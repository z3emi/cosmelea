<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * عرض الصفحة الرئيسية مع المنتجات المميزة وجميع الأقسام.
     */
    public function homepage()
    {
        $featuredProducts = Product::latest()->take(8)->get();
        $categories = Category::latest()->get(); // جلب جميع الأقسام
        return view('frontend.homepage', compact('featuredProducts', 'categories'));
    }

    /**
     * عرض صفحة المتجر مع جميع المنتجات.
     */
    public function shop()
    {
        $products = Product::latest()->paginate(12);
        $categories = Category::all();
        return view('frontend.shop', compact('products', 'categories'));
    }

    /**
     * عرض صفحة تفاصيل المنتج الواحد.
     */
    public function productDetail(Product $product)
    {
        // يمكنك جلب منتجات مشابهة هنا إذا أردت
        return view('frontend.product_detail', compact('product'));
    }
}
