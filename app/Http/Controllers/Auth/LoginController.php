<?php
// ======================================================================
// الملف: app/Http/Controllers/Auth/LoginController.php
// ======================================================================
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $login = request()->input('login');
        // التحقق فقط بين البريد الإلكتروني ورقم الهاتف
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        request()->merge([$field => $login]);
        return $field;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }
}