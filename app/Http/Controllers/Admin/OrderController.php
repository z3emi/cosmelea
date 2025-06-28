<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * عرض جميع الطلبات مع بحث وفرز.
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // فلتر البحث
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone_number', 'like', "%{$searchTerm}%");
            });
        }

        // فلتر الترتيب
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc');
        if (in_array($sortBy, ['id', 'total_amount', 'status', 'source', 'created_at'])) {
             $query->orderBy($sortBy, $sortDir);
        }

        $orders = $query->paginate(15)->withQueryString();
        
        return view('admin.orders.index', compact('orders', 'sortBy', 'sortDir'));
    }

    /**
     * عرض فورم إنشاء طلب يدوي.
     */
    public function create()
    {
        $users = User::where('type', 'user')->get();
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * تخزين الطلب اليدوي.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'source' => 'required|string',
            'governorate' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'nearest_landmark' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($request->products as $productData) {
                $product = Product::find($productData['id']);
                if ($product->stock_quantity < $productData['quantity']) {
                    throw new \Exception("الكمية المطلوبة للمنتج '{$product->name_ar}' غير متوفرة.");
                }
                $totalAmount += $product->price * $productData['quantity'];
            }

            $order = Order::create([
                'user_id' => $request->user_id,
                'source' => $request->source,
                'governorate' => $request->governorate,
                'city' => $request->city,
                'nearest_landmark' => $request->nearest_landmark,
                'notes' => $request->notes,
                'total_amount' => $totalAmount,
                'status' => 'processing',
            ]);

            foreach ($request->products as $productData) {
                $product = Product::find($productData['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' => $product->price,
                ]);
                $product->decrement('stock_quantity', $productData['quantity']);
            }

            DB::commit();
            return redirect()->route('admin.orders.invoice', $order->id)->with('success', 'تم إنشاء الطلب بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    /**
     * عرض تفاصيل طلب واحد.
     */
    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * عرض فورم تعديل الطلب.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * تحديث بيانات الطلب الأساسية.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'governorate' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'nearest_landmark' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        
        $order->update($request->only(['governorate', 'city', 'nearest_landmark', 'notes']));

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'تم تحديث تفاصيل الطلب بنجاح.');
    }

    /**
     * تحديث حالة الطلب.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled,returned']);
        
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    /**
     * نقل الطلب إلى سلة المحذوفات (حذف ناعم).
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'تم نقل الطلب إلى سلة المحذوفات.');
    }

    /**
     * عرض سلة المحذوفات.
     */
    public function trash()
    {
        $trashedOrders = Order::onlyTrashed()->with('user')->latest()->paginate(10);
        return view('admin.orders.trash', compact('trashedOrders'));
    }

    /**
     * استعادة طلب محذوف.
     */
    public function restore($id)
    {
        Order::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.orders.trash')->with('success', 'تم استعادة الطلب بنجاح.');
    }

    /**
     * حذف الطلب بشكل نهائي.
     */
    public function forceDelete($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();
        return redirect()->route('admin.orders.trash')->with('success', 'تم حذف الطلب نهائياً.');
    }

    /**
     * عرض الفاتورة القابلة للطباعة.
     */
    public function invoice(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.invoice', compact('order'));
    }
}
