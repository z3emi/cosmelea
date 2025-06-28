<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * عرض صفحة الملف الشخصي.
     */
    public function show()
    {
        $user = Auth::user();
        return view('frontend.profile.show', compact('user'));
    }

    /**
     * تحديث بيانات المستخدم الأساسية.
     */
    public function updateDetails(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.show')->with('success', 'تم تحديث بياناتك بنجاح.');
    }

    /**
     * تحديث كلمة المرور.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }
}
