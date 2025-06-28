<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * عرض صفحة سلة المشتريات.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return view('frontend.cart.index', compact('cartItems'));
    }

    /**
     * إضافة منتج إلى سلة المشتريات.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // التحقق إذا كان المنتج موجوداً مسبقاً في السلة
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name_ar,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image_url" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'تم إضافة المنتج إلى السلة بنجاح!');
    }

    /**
     * تحديث كمية منتج في السلة.
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'تم تحديث السلة بنجاح.');
        }
    }

    /**
     * حذف منتج من السلة.
     */
    public function destroy(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'تم حذف المنتج من السلة بنجاح.');
        }
    }
}
