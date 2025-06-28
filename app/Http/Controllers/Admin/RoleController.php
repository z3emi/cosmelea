<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * عرض جميع الأدوار.
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * عرض فورم إنشاء دور جديد.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * تخزين الدور الجديد.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', 'تم إنشاء الدور بنجاح.');
    }

    /**
     * عرض فورم تعديل الدور.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * تحديث الدور.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', 'تم تحديث الدور بنجاح.');
    }

    /**
     * حذف الدور.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'تم حذف الدور بنجاح.');
    }
}
