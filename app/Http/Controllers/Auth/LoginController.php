<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if (!$user) {
            $message = "아이디 없음";
        } else {
            if (!Hash::check($request->password, $user->password)) {
                $message = "비밀번호 틀림";
            } else {
                $message =
                    "다른 예기치 않은 오류가 발생했습니다. 관리자에게 문의 하세요";
            }
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }
}
