<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        // Verificar si el usuario es administrador
        if ($user->admin == 1) {
            $g2fa = app(Google2FA::class);

                if (!$request->g2fa) {
                    return redirect(RouteServiceProvider::LOGIN)->with('error', 'Te falta el codigo de acceso');
                }

                $decryptedkey = Crypt::decryptString($user->g2fa);

                if (!$g2fa->verifyKey($decryptedkey, $request->input('g2fa'))) {
                    return redirect(RouteServiceProvider::LOGIN)->with('error', 'Codigo de acceso incorrecto');
                }
                $request->authenticate();

                $request->session()->regenerate();

                return redirect()->intended(RouteServiceProvider::HOME);
                
        } else {
            // Si el usuario no es administrador, proceder con la autenticación normal sin 2FA
            $request->authenticate();

            // Regenerar la sesión
            $request->session()->regenerate();

            // Redirigir al usuario a la página de inicio
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
