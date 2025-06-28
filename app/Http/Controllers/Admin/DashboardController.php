<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية مع الإحصائيات.
     */
    public function index()
    {
        $userCount = User::count();
        $orderCount = Order::count();
        $productCount = Product::count();

        return view('admin.dashboard', compact('userCount', 'orderCount', 'productCount'));
    }
}
