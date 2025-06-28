<?php
// ======================================================================
// الملف: app/Http/Controllers/Admin/CustomerController.php
// ======================================================================
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('orders')->latest()->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:customers,phone_number',
            'email' => 'nullable|string|email|max:255|unique:customers,email',
            'governorate' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address_details' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'تم إنشاء العميل بنجاح.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => function ($query) {
            $query->latest()->paginate(10);
        }]);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:customers,phone_number,' . $customer->id,
            'email' => 'nullable|string|email|max:255|unique:customers,email,' . $customer->id,
            'governorate' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address_details' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'تم تحديث بيانات العميل بنجاح.');
    }
}