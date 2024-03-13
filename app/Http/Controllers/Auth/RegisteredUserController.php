<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Rules\Recaptcha;
use Illuminate\Support\Carbon;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:60', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8', 'max:50' , Password::min(8)->letters()->mixedCase()->numbers()->uncompromised()],
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ]);

        $admin = User::count()===0;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $admin,
            
        ]);

        $clave = null;

        if (!$user->admin) {
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect(RouteServiceProvider::LOGIN);
        }
        else{
            $g2fa = app(Google2FA::class);
            $clave = $g2fa->generatesecretkey();
            $seckey = $clave;
                $encryptkey = Crypt::encryptString($seckey);
                $user->g2fa = $encryptkey;
            $user->save();
            return redirect(RouteServiceProvider::LOGIN)->with('clave', $clave);
        }

        /*event(new Registered($user));

       Auth::login($user);*/
    }
}
