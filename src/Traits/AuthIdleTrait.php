<?php

namespace Masuresh124\AuthIdle\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
trait AuthIdleTrait
{

    /**
     * This function is used to validate idle
     */
    public function validateIdle()
    {
        $userCheck = auth()->check();
        if ($userCheck) {
            $lastActivity = session('authIdleLastActivityTime');
            $timeout      = config('auth-idle.timeout') * 60;

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                return false;
            }
            session(['authIdleLastActivityTime' => time()]);
        }
        return true;
    }

    /**
     * This function is used to logout sessions
     */

    public function idleLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    /**
     * This function is used to redirect to login
     */
    public function redirectToLogin(Request $request)
    {
        $this->idleLogout($request);
        return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
    }

}
