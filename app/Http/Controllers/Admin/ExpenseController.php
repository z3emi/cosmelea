<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        // فلترة حسب الشهر والسنة
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereYear('expense_date', $request->year)
                  ->whereMonth('expense_date', $request->month);
        }

        $expenses = $query->latest()->paginate(15);
        return view('admin.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('admin.expenses.index')->with('success', 'تم تسجيل المصروف بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('admin.expenses.index')->with('success', 'تم تحديث المصروف بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'تم حذف المصروف بنجاح.');
    }
}
