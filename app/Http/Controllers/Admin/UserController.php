<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use App\Models\Order; // تأكد من إضافة هذا السطر لاستيراد نموذج Order

class UserController extends Controller
{
    /**
     * عرض جميع المستخدمين مع بحث وفلترة.
     */
    public function index(Request $request)
    {
        $query = User::withCount('orders')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone_number', 'like', "%{$searchTerm}%")
                  ->orWhere('username', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    /**
     * عرض فورم إنشاء مستخدم جديد يدوياً.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * تخزين المستخدم الجديد.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'type' => 'required|in:admin,user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المستخدم بنجاح.');
    }


    /**
     * عرض فورم تعديل المستخدم.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $orders = $user->orders()->latest()->take(5)->get();
        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'orders'));
    }

    /**
     * تحديث بيانات المستخدم.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $user->id,
            'type' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'username', 'email', 'phone_number', 'type');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $roles = Role::whereIn('id', $request->input('roles', []))->get();
        $user->syncRoles($roles);
        
        $permissions = Permission::whereIn('id', $request->input('permissions', []))->get();
        $user->syncPermissions($permissions);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    /**
     * عرض كل طلبات المستخدم.
     */
    public function showUserOrders(User $user)
    {
        $orders = $user->orders()->latest()->paginate(15);
        return view('admin.users.orders', compact('user', 'orders'));
    }

    /**
     * حظر المستخدم.
     */
    public function ban(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك حظر حسابك الخاص.');
        }
        $user->update(['banned_at' => Carbon::now()]);
        return redirect()->route('admin.users.index')->with('success', 'تم حظر المستخدم بنجاح.');
    }

    /**
     * إلغاء حظر المستخدم.
     */
    public function unban(User $user)
    {
        $user->update(['banned_at' => null]);
        return redirect()->route('admin.users.index')->with('success', 'تم إلغاء حظر المستخدم بنجاح.');
    }
    
    /**
     * حذف المستخدم.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
