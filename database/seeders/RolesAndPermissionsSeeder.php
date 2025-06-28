<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إعادة تعيين الكاش الخاص بالأدوار والصلاحيات
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الصلاحيات التفصيلية
        $permissions = [
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'view-orders', 'create-orders', 'edit-orders', 'delete-orders',
            'view-trashed-orders', 'restore-orders', 'force-delete-orders',
            'view-users', 'create-users', 'edit-users', 'delete-users', 'ban-users',
            'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
            'view-expenses', 'create-expenses', 'edit-expenses', 'delete-expenses',
            'view-inventory',
            'view-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // إنشاء دور "Super-Admin" وإعطاؤه كل الصلاحيات
        $superAdminRole = Role::create(['name' => 'Super-Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // إنشاء دور "مدير الطلبات" وإعطاؤه صلاحيات محددة
        $orderManagerRole = Role::create(['name' => 'Order-Manager']);
        $orderManagerPermissions = [
            'view-orders', 'create-orders', 'edit-orders', 
            'delete-orders', 'view-trashed-orders', 'restore-orders'
        ];
        // ** التعديل هنا: جلب الصلاحيات من قاعدة البيانات مباشرة قبل إعطائها **
        $orderManagerRole->syncPermissions(Permission::whereIn('name', $orderManagerPermissions)->get());
        
        // إنشاء دور "كاتب محتوى"
        $contentCreatorRole = Role::create(['name' => 'Content-Creator']);
        $contentCreatorPermissions = [
            'view-products', 'create-products', 'edit-products'
        ];
        $contentCreatorRole->syncPermissions(Permission::whereIn('name', $contentCreatorPermissions)->get());
    }
}
