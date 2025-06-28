<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * عرض صفحة المخزن.
     */
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.inventory.index', compact('products'));
    }
}
