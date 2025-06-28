<?php
// ======================================================================
// الملف: app/Http/Controllers/Auth/RegisterController.php
// (مطور ليربط المستخدم بالعميل تلقائياً)
// ======================================================================
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * تم تطوير هذه الدالة بالكامل
     * لإنشاء أو ربط العميل بالمستخدم
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // البحث عن عميل بنفس رقم الهاتف
        $customer = Customer::where('phone_number', $request->phone_number)->first();

        if ($customer && is_null($customer->user_id)) {
            // إذا وجدنا عميل غير مرتبط، نربطه بالمستخدم الجديد
            $customer->update(['user_id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
        } else {
            // إذا لم نجد عميل، ننشئ عميل جديد
            Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'email' => $user->email,
            ]);
        }

        event(new Registered($user));
        $this->guard()->login($user);
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}