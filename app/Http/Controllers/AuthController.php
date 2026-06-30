<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class AuthController
 *
 * Controlador para gestionar el inicio de sesión, registro y cierre de sesión de usuarios.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return View
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa la autenticación del usuario.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('feedback.message', 'Sesión iniciada con éxito. Bienvenido al Circuito Kitsune.')
                ->with('feedback.type', 'success');
        }

        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->with('feedback.message', 'Las credenciales ingresadas no coinciden con nuestros registros.')
            ->with('feedback.type', 'danger');
    }

    /**
     * Muestra el formulario de registro.
     *
     * @return View
     */
    public function register(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa y almacena un nuevo usuario en la base de datos.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Este email ya está registrado en el circuito.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('feedback.message', 'Cuenta creada exitosamente. Tu firma digital ya está en el sistema.')
            ->with('feedback.type', 'success');
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('feedback.message', 'Sesión cerrada con éxito. La señal ha sido desconectada.')
            ->with('feedback.type', 'success');
    }
}
