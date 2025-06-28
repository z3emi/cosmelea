<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * عرض صفحة التقارير المالية.
     */
    public function index()
    {
        // 1. حساب إجمالي الإيرادات (من الطلبات المكتملة فقط)
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');

        // 2. حساب إجمالي تكلفة البضاعة المباعة (COGS)
        $totalCogs = OrderItem::query()
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })
            ->select(DB::raw('SUM(order_items.quantity * products.cost_price) as total_cost'))
            ->value('total_cost') ?? 0;

        // 3. حساب إجمالي المصاريف
        $totalExpenses = Expense::sum('amount');

        // 4. حساب الربح الإجمالي والصافي
        $grossProfit = $totalRevenue - $totalCogs;
        $netProfit = $grossProfit - $totalExpenses;

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalCogs',
            'totalExpenses',
            'grossProfit',
            'netProfit'
        ));
    }
}
