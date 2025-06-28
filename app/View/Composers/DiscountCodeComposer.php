<?php

namespace App\View\Composers;

use App\Models\DiscountCode;
use Illuminate\View\View;

class DiscountCodeComposer
{
    /**
     * ربط البيانات بالواجهة.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        try {
            // جلب جميع كودات الخصم النشطة والتي لم تنتهِ صلاحيتها بعد
            $activeDiscountCodes = DiscountCode::where('is_active', true)
                ->where(function ($query) {
                    $query->where('expires_at', '>', now())
                          ->orWhereNull('expires_at');
                })
                ->get();

            $view->with('activeDiscountCodes', $activeDiscountCodes);
        } catch (\Exception $e) {
            // في حال حدوث أي خطأ (مثل عدم وجود الجدول)، أرسل مصفوفة فارغة لتجنب توقف الموقع
            $view->with('activeDiscountCodes', []);
        }
    }
}
